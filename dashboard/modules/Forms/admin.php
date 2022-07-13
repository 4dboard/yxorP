<?php $app->on('admin.init', function () {
    if (!$this->module('yxorp')->getGroupRights('forms')) {
        $this->bind('/forms/*', function () {
            return $this('admin')->denyRequest();
        });
        return;
    }
    $this->bindClass('Forms\\Controller\\Admin', 'forms');
    $active = strpos($this['route'], '/forms') === 0;
    $this->helper('admin')->addMenuItem('modules', ['label' => 'Forms', 'icon' => 'forms:icon.svg', 'route' => '/forms', 'active' => $active]);
    if ($active) {
        $this->helper('admin')->favicon = 'forms:icon.svg';
    }
    $this->on('yxorp.search', function ($search, $list) {
        foreach ($this->module('forms')->forms() as $form => $meta) {
            if (stripos($form, $search) !== false || stripos($meta['label'], $search) !== false) {
                $list[] = ['icon' => 'inbox', 'title' => $meta['label'] ? $meta['label'] : $meta['name'], 'url' => $this->routeUrl('/forms/entries/' . $meta['name'])];
            }
        }
    });
    $this->on('admin.dashboard.widgets', function ($widgets) {
        $forms = $this->module('forms')->forms(false);
        $widgets[] = ['name' => 'forms', 'content' => $this->view('forms:views/widgets/dashboard.php', compact('forms')), 'area' => 'aside-left'];
    }, 100);
    $this->on('yxorp.webhook.events', function ($triggers) {
        foreach (['forms.save.after', 'forms.save.after.{$name}', 'forms.save.before', 'forms.save.before.{$name}', 'forms.submit.after', 'forms.submit.before',] as &$evt) {
            $triggers[] = $evt;
        }
    });
});