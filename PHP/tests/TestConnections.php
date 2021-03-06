<?php declare(strict_types=1);

# Import db_api.php
require_once('../db_api.php');
use PHPUnit\Framework\TestCase;

final class TestConnections extends TestCase
{
    private $id_a;
    private $connection_a = "Alex";
    private $email_a = "alex@yahoo.co";
    private $address_a = "123 Side Street";
    private $zip_a = 12345;
    private $city_a = "Buffalo";
    private $password_a = "password";
    private $birthday_a = "1999-12-12";

    private $id_b;
    private $connection_b = "Hazel";
    private $email_b = "hazel@yahoo.co";
    private $address_b = "123 Main Street";
    private $zip_b = 67891;
    private $city_b = "Finger Lakes";
    private $password_b = "password";
    private $birthday_b = "2000-01-21";


    function setUp(): void
    {
        create_user($this->connection_a, $this->email_a, $this->password_a, $this->address_a, $this->city_a, $this->zip_a, $this->birthday_a);
        create_user(
            $this->connection_b, $this->email_b, $this->password_b, $this->address_b, $this->city_b, $this->zip_b, $this->birthday_b
        );

        $this->id_a = get_user_id($this->email_a);
        $this->id_b = get_user_id($this->email_b);

        $this->assertGreaterThan(0, $this->id_a, "Error getting ID of user A in setUp() function");
        $this->assertGreaterThan(0, $this->id_b, "Error getting ID of user B in setUp() function");
    }

    function tearDown(): void
    {
        exec_query("DELETE FROM Users WHERE name=? AND email=?", [$this->connection_a, $this->email_a]);
        exec_query("DELETE FROM Users WHERE name=? AND email=?", [$this->connection_b, $this->email_b]);
    }

    function testAddConnectionRequest(): void
    {
        // Send a request from user A to user B
        $add_attempt = add_connection_request($this->id_a, $this->id_b);

        $this->assertEquals($add_attempt, 1, "Failed to add connection request");

        // Get the connections requests row from the Connection_requests table
        // for user B
        // $result = exec_query("SELECT * FROM Connection_requests WHERE id=?", [$this->id_b]);
        $result = exec_query("SELECT * FROM Connection_requests WHERE sent_from=?", [$this->id_a]);

        $this->assertNotNull($result, "Result was null after executing query on Connection_requests table");
        $this->assertGreaterThan(0, $result->num_rows, "No one in connection requests has sent_from's ID");

        $arr = $result->fetch_assoc();
        $requesting_id = $arr["sent_from"];
        $receiving_id = $arr["sent_to"];

        // Make sure that user B received the request and user A sent the
        // request
        $this->assertEquals($this->id_b, $receiving_id, "Receiving id (A's ID) is wrong");
        $this->assertEquals($this->id_a, $requesting_id, "Requesting id (B's ID) is wrong");

        // Attempt to send another request from A to B (should fail)
        $add_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($add_attempt, 0, "Successfully added an existing connection request");

        // Attempt to send a request from B to A (should fail)
        $add_attempt = add_connection_request($this->id_b, $this->id_a);
        $this->assertEquals($add_attempt, 0, "Successfully sent a request to someone request a connection");
    }

    function testAddConnection(): void
    {
        // Send a request from user A to user B
        $add_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($add_attempt, 1, "Failed to add connection request");

        // add_connection is called when the person who received the connection
        // request accepts it

        // Simulate user A accepting request (should fail)
        $accept_attempt = add_connection($this->id_b, $this->id_a);
        $this->assertEquals($accept_attempt, 0, "Added connection when it should have failed");

        // Simulate user B accepting request (should succeed)
        $accept_attempt = add_connection($this->id_a, $this->id_b);
        $this->assertEquals($accept_attempt, 1, "Couldn't add connection when I should be able to");

        // Simulate user B accepting request again (should fail, already accepted)
        $accept_attempt = add_connection($this->id_a, $this->id_b);
        $this->assertEquals($accept_attempt, 0, "Added connection when it was already accepted");

    }

    function testRemoveConnectionRequest(): void
    {
        // Send a request from user A to user B
        $add_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($add_attempt, 1, "Failed to add connection request");

        // Attempt to remove the connection request with the sender as B (should fail)
        $remove_attempt = remove_connection_request($this->id_b);
        $this->assertEquals($remove_attempt, 0, "Removed a connection request sent by a user that didn't send one");

        // Attempt to remove the connection request
        $remove_attempt = remove_connection_request($this->id_a);
        $this->assertEquals($remove_attempt, 1, "Failed to remove connection request");

        // Ensure that sent_from's sent_to column was appropriately updated
        $query = "SELECT * FROM Connection_requests WHERE sent_from=?";
        $result = exec_query($query, [$this->id_a]);
        $this->assertNotNull($result, "Failed to exec_query in testRemoveConnectionRequest");
        $this->assertGreaterThan(0, $result->num_rows, "No row where sent_from equal to id_a in Connection_requests");
        $this->assertEquals($result->fetch_assoc()["sent_to"], $this->id_a, "sent_to column improperly updated");

        // Attempt to remove a non-existent connection request (should fail)
        $remove_attempt = remove_connection_request($this->id_a);
        $this->assertEquals($remove_attempt, 0, "Successfully removed a non-existent connection request");
    }

    function testRemoveConnection(): void
    {
        // Send a request from user A to user B
        $add_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($add_attempt, 1, "Failed to add connection request");

        // Accept the request
        $accept_attempt = add_connection($this->id_a, $this->id_b);
        $this->assertEquals($accept_attempt, 1, "Failed to accept connection request");

        // Remove the request
        $remove_attempt = remove_connection($this->id_a, $this->id_b);
        $this->assertEquals($remove_attempt, 1, "Failed to remove connection");

        // Make sure that user A's partner was reset to user A's id
        $query = "SELECT * FROM Users WHERE id=?";
        $result = exec_query($query, [$this->id_a]);
        $this->assertNotNull($result, "Failed to exec_query in testRemoveConnection");
        $this->assertGreaterThan(0, $result->num_rows, "No user with ID matching user A's ID");
        $this->assertEquals($result->fetch_assoc()["partner"], $this->id_a, "Improperly removed user A's connection");

        // Make sure that user B's partner was reset to user B's id
        $result = exec_query($query, [$this->id_b]);
        $this->assertNotNull($result, "Failed to exec_query in testRemoveConnection");
        $this->assertGreaterThan(0, $result->num_rows, "No user with ID matching user B's ID");
        $this->assertEquals($result->fetch_assoc()["partner"], $this->id_b, "Improperly removed user B's connection");

        // Remove the request again (should fail)
        $remove_attempt = remove_connection($this->id_a, $this->id_b);
        $this->assertEquals($remove_attempt, 0, "Successfully removed a non-existent connection request");

    }

    function testGetPartner(): void
    {
        // Send a request from user A to user B
        $send_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($send_attempt, 1, "Couldn't add connection request");

        // Accept the request
        $accept_attempt = add_connection($this->id_a, $this->id_b);
        $this->assertEquals($accept_attempt, 1, "Failed to accept connection request");

        // Make sure that both users have a partner
        $a_has_partner = has_partner($this->id_a);
        $this->assertTrue($a_has_partner, "A should have a partner, but doesn't");

        $b_has_partner = has_partner($this->id_b);
        $this->assertTrue($b_has_partner, "B should have a partner, but doesn't");

        // Make sure that A's partner is B, and vice versa
        $a_partner = get_partner($this->id_a);
        $this->assertEquals($a_partner, $this->id_b, "A's partner isn't B");

        $b_partner = get_partner($this->id_b);
        $this->assertEquals($b_partner, $this->id_a, "B's partner isn't A");
    }

    function testGetRequests(): void
    {
        // Send a request from user A to user B
        $send_attempt = add_connection_request($this->id_a, $this->id_b);
        $this->assertEquals($send_attempt, 1, "Couldn't add connection request");

        // Accept the request
        $accept_attempt = add_connection($this->id_a, $this->id_b);
        $this->assertEquals($accept_attempt, 1, "Failed to accept connection request");

        // Make sure that user A doesn't have an incoming request
        $a_has_request = has_requests($this->id_a);
        $this->assertFalse($a_has_request, "A had a request when it shouldn't have");

        // Make sure that user B hasn't sent a request
        $b_sent_request = sent_request($this->id_b);
        $this->assertFalse($b_sent_request, "B sent a request when it shouldn't have");

        // Make sure that user A has sent a request
        $a_sent_request = sent_request($this->id_a);
        $this->assertTrue($a_sent_request, "A didn't sent a request when it should have");

        // Make sure that B has received a request
        $b_has_request = has_requests($this->id_b);
        $this->assertTrue($b_has_request, "B didn't have a request when it should have");

        // Make sure that B's request came from A
        $b_requests = get_requests($this->id_b);
        $this->assertNotEmpty($b_requests, "No requests found for B");
        $this->assertTrue(in_array($this->id_b, $b_requests), "A's ID not found in B's request list");
    }

}