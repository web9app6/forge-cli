<?php

it('allows to switch the server context with an menu', function () {
    $this->client->shouldReceive('servers')->andReturn([
        (object) ['id' => 1, 'name' => 'production', 'ipAddress' => '123.456.789.000'],
        (object) ['id' => 2, 'name' => 'staging', 'ipAddress' => '789.456.123.111'],
    ]);

    $this->client->shouldReceive('server')->andReturn(
        (object) ['id' => 2, 'name' => 'staging', 'ipAddress' => '789.456.123.111'],
    );

    $this->artisan('server:switch')
        ->expectsQuestion('<fg=yellow>‣</> <options=bold>Which Server Would You Like To Switch To</>', 2)
        ->expectsOutput('==> Current Server Context Changed Successfully To [staging]')->run();

    expect($this->config->get('server'))->toBe(2);
});

it('allows to switch the server context with an option', function () {
    $this->client->shouldReceive('server')->andReturn(
        (object) ['id' => 2, 'name' => 'staging', 'ipAddress' => '789.456.123.111'],
    );

    $this->client->shouldReceive('servers')->andReturn([
        (object) ['id' => 1, 'name' => 'production', 'ipAddress' => '123.456.789.000'],
        (object) ['id' => 2, 'name' => 'staging', 'ipAddress' => '789.456.123.111'],
    ]);

    $this->artisan('server:switch', ['server' => 'staging'])
        ->expectsOutput('==> Current Server Context Changed Successfully To [staging]')
        ->run();

    expect($this->config->get('server'))->toBe(2);
});
