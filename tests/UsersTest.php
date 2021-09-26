<?php
use PHPUnit\Framework\TestCase;
class UsersTest extends TestCase 
{
    private $http;

    public function setUp(): void
    {
        $this->http = new GuzzleHttp\Client(['base_uri' => 'http://localhost/leaderboard-api/']);
    }

    public function tearDown(): void 
    {
        $this->http = null;
    }

    public function testgetdata()
    {
        $response = $this->http->get('/leaderboard-api/read');
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(204, $response->getStatusCode(),'No Posts Found');

        $response = $this->http->post('/leaderboard-api/read', [
            'json' => [
                'uid'     => '1'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals(204, $response->getStatusCode(),'No Posts Found');
               
    }
    public function testinsertdata()
    {
       $response = $this->http->post('/leaderboard-api/insert', [
            'json' => [
                'name'     => 'Florance',
                'age'    => 37,
                'address' => 'canada'
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->post('/leaderboard-api/insert', [
            'json' => [
                'name'     => 'Florance',
                'age'    => -37,
                'address' => 'canada'
            ]
        ]);

        $this->assertEquals(406, $response->getStatusCode(),'Age must be greater than zero');

        $response = $this->http->post('/leaderboard-api/insert', [
            'json' => [
                'age'    => 37,
                'address' => 'canada'
            ]
        ]);

        $this->assertEquals(406, $response->getStatusCode(), 'Missing name should return 406 error');

        $response = $this->http->post('/leaderboard-api/insert', [
            'json' => [
                'name'   => 'Florance',
                'address' => 'canada'
            ]
        ]);

        $this->assertEquals(406, $response->getStatusCode(), 'Age less than or equal to zero return 406 error');

        $response = $this->http->post('/leaderboard-api/insert', [
            'json' => [
                'name'   => 'Florance',
                'age'    => 37,
            ]
        ]);

        $this->assertEquals(406, $response->getStatusCode(), 'Missing address should return 406 error');
       
    }

    public function testaddpoint()
    {
        $uid = '1';

       $response = $this->http->post('/leaderboard-api/addpoint', [
            'json' => [
                'uid'     => $uid
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->post('/leaderboard-api/addpoint', [
            'json' => [
                'uid'     => 100
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode(), 'User does not exist so points are not be added');

        $response = $this->http->post('/leaderboard-api/addpoint');
        $this->assertEquals(406, $response->getStatusCode(), 'Userid is missing so points are not be added');
        
    }

    public function testsubtractpoint()
    {
        $uid = '4';

       $response = $this->http->post('/leaderboard-api/subtractpoint', [
            'json' => [
                'uid'     => $uid
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->post('/leaderboard-api/subtractpoint', [
            'json' => [
                'uid'     => 100
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode(), 'User does not exist or point is less than zero so points are not be subtracted.');

        $response = $this->http->post('/leaderboard-api/subtractpoint');
        $this->assertEquals(406, $response->getStatusCode(), 'Userid is missing so points are not be subtracted');
        
    }

    public function testdeletedata()
    {
        $uid = '34';

       $response = $this->http->post('/leaderboard-api/delete   ', [
            'json' => [
                'uid'     => $uid
            ]
        ]);

        $this->assertEquals(200, $response->getStatusCode());

        $response = $this->http->post('/leaderboard-api/delete   ', [
            'json' => [
                'uid'     => 100
            ]
        ]);
        $this->assertEquals(400, $response->getStatusCode(), 'User not deleted becuase userid does not exist');

        $response = $this->http->post('/leaderboard-api/delete');
        $this->assertEquals(406, $response->getStatusCode(), 'User not deleted becuase userid is missing');
        
    }

    

}
?>