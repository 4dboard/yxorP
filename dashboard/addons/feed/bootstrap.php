<?php $name = 'Feed';
if (!isset($app['modules'][strtolower($name)])) {
    $app->on('app.layout.contentbefore', function () use ($name) {
        echo '<p><span class="uk-badge uk-badge-warning"><i class="uk-margin-small-right uk-icon-warning"></i>' . $name . '</span> You have to rename the addon folder <code>' . basename(__DIR__) . '</code> to <code>' . $name . '</code>.</p>';
    });
    return;
}
$this->module('feed')->extend(['feed' => function ($name, $options = []) {
    $collection = $this->app->module('collections')->collection($name);
    foreach ($collection['fields'] as $field) {
        $fields[$field['name']] = $field;
    }
    $collection['fields'] = $fields;
    $entries = $this->app->module('collections')->find($name, $options);
    if ($path = $this->app->path("#config:feed/{$name}.php")) $view = "#config:feed/{$name}.php"; else $view = 'feed:views/rss.php';
    return $this->app->view($view, compact('entries', 'collection', 'options'));
}, 'feeds' => function ($output = 'json') {
    $extended = false;
    $user = $this->app->module('yxorp')->getUser();
    if ($user) {
        $collections = $this->app->module('collections')->getCollectionsInGroup($user['group'], $extended);
    } else {
        $collections = $this->app->module('collections')->collections($extended);
    }
    $entries = [];
    foreach ($collections as $feed => $val) {
        $entries[$feed] = ['name' => $val['name'], 'label' => $val['label'] ?? '', '_id' => $val['_id'], 'description' => $val['description'] ?? '', 'url' => $this->app['site_url'] . $this->app['base_route'] . "/api/feed/get/$feed"];
    }
    if ($output == 'rss') return $this->app->view('feed:views/listFeeds.php', compact('entries'));
    return $entries;
}]);
if (YXORP_API_REQUEST) {
    include_once(__DIR__ . '/Controller/RestApi.php');
    $app->on('yxorp.rest.init', function ($routes) {
        $routes['feed'] = 'Feed\\Controller\\RestApi';
    });
    $app->on('yxorp.api.authenticate', function ($data) {
        if (!isset($this['feed']['public']) || !$this['feed']['public']) return;
        if ($data['user'] || $data['resource'] != 'feed') return;
        if (empty($data['query']['params']) && ($default = $this['feed']['default'] ?? false)) {
            $collection = $this->module('collections')->collection($default);
            if ($collection && isset($collection['acl']['public'])) {
                $data['authenticated'] = true;
                $data['user'] = ['_id' => null, 'group' => 'public'];
            }
        }
        if (isset($data['query']['params'][1])) {
            $collection = $this->module('collections')->collection($data['query']['params'][1]);
            if ($collection && isset($collection['acl']['public'])) {
                $data['authenticated'] = true;
                $data['user'] = ['_id' => null, 'group' => 'public'];
            }
        }
        if (isset($data['query']['params'][0]) && $data['query']['params'][0] == 'listFeeds') {
            $data['authenticated'] = true;
            $data['user'] = ['_id' => null, 'group' => 'public'];
        }
    });
}