<?php

use PHPUnit\Framework\TestCase;
require '../../../includes/functions/functions.php';

class functions extends TestCase
{
    public function testGetTitleWithTitleSet() {
        global $pageTitle;
        global $mockSomething;
        $mockSomething = "Hola";
        $pageTitle = "My Page Title";
        ob_start();
        getTitle();
        $output = ob_get_clean();

        $this->assertEquals("My Page Title | Barbershop Website", $output);

        unset($pageTitle);
    }

    public function testGetTitleWithNoTitleSet() {
        global $pageTitle;
        $pageTitle = null;
        ob_start();
        getTitle();
        $output = ob_get_clean();
        $this->assertEquals("Barbershop Website", $output);
    }

    public function testCountItems() {
        $mockConnection = $this->createMock(PDO::class);

        $table = "your_table_name";
        $item = "your_item_name";

        $mockStatement = $this->createMock(PDOStatement::class);

        $mockStatement->expects($this->once())
            ->method('execute');
        $mockStatement->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(42);

        $mockConnection->expects($this->once())
            ->method('prepare')
            ->with("SELECT COUNT($item) FROM $table")
            ->willReturn($mockStatement);

        global $con;
        $con = $mockConnection;

        $count = countItems($item, $table);

        $this->assertEquals(42, $count);
    }
}
