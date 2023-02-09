<?php
namespace Tests;

require_once('./vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use GuzzleHttp\Client;

class WorkTest extends TestCase
{
    protected $viewPath;
    protected $appUrl;

    protected function setUp()
    {
        $this->viewPath = '';
        $this->appUrl = 'http://localhost/TodoList';
    }

    public function testCanBeAccessWorkIndex(): void
    {
        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCanBeAccessCalendarPage(): void
    {
        $this->assertFileExists( $this->viewPath . 'calendar.php' );
    }

    public function testCanCreateWork(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test',
                    'startDate' => '2023/02/09',
                    'endDate' => '2023/02/11',
                    'status' => 1,
                    'type' => 'ADD'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotCreateWorkWithEmptyWorkName(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => '',
                    'startDate' => '2023/02/09',
                    'endDate' => '2023/02/11',
                    'status' => 1,
                    'type' => 'ADD'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotCreateWorkWithEmptyStartDate(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test',
                    'endDate' => '2023/02/11',
                    'status' => 1,
                    'startDate' => '',
                    'type' => 'ADD'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotCreateWorkWithEmptyEndDate(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test',
                    'startDate' => '2023/02/09',
                    'status' => 1,
                    'endDate' => '',
                    'type' => 'ADD'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotCreateWorkWithEmptyStatus(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test',
                    'startDate' => '2023/02/09',
                    'endDate' => '2023/02/11',
                    'status' => '',
                    'type' => 'ADD'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCanUpdateWork(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test update',
                    'startDate' => '2020/03/02',
                    'endDate' => '2020/03/02',
                    'status' => 1,
                    'id' => 14,
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotUpdateWorkWithEmptyWorkName(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'startDate' => '2020/03/02',
                    'endDate' => '2020/03/02',
                    'status' => 1,
                    'id' => 14,
                    'workName' => '',
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotUpdateWorkWithEmptyStartDate(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test update',
                    'endDate' => '2020/03/02',
                    'status' => 1,
                    'id' => 14,
                    'startDate' => '',
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotUpdateWorkWithEmptyEndDate(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test update',
                    'startDate' => '2020/03/02',
                    'status' => 1,
                    'id' => 14,
                    'endDate' => '',
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotUpdateWorkWithEmptyStatus(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test update',
                    'startDate' => '2020/03/02',
                    'endDate' => '2020/03/02',
                    'id' => 14,
                    'status' => '',
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotUpdateWorkWithEmptyId(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'workName' => 'Work unit test update',
                    'startDate' => '2020/03/02',
                    'endDate' => '2020/03/02',
                    'status' => 1,
                    'id' => '',
                    'type' => 'EDIT'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCanDeleteWork(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'id' => '14',
                    'type' => 'DELETE'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }

    public function testCannotDeleteWorkWithoutId(): void
    {
        $client = new Client();

        $response = $client->request(
            'POST',
            $this->appUrl . '/index.php',
            [
                'form_params' => [
                    'id' => '',
                    'type' => 'DELETE'
                ]
            ]
        );

        $this->assertFileExists( $this->viewPath . 'index.php' );
    }
}