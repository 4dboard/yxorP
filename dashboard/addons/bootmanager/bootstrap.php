<?php define('YXORP_BOOTMANAGER', 1);
$this->on('yxorp.bootstrap', function () {
    $loadmodules = $this->retrieve('loadmodules');
    $loadmodules['bootmanager'] = __DIR__ . '/addons';
    $this->set('loadmodules', $loadmodules);
    $bootManager = array_replace_recursive($this->storage->getKey('yxorp/options', 'bootmanager', []), $this->retrieve('config/bootmanager', []));
    $bootOrder = [];
    if (YXORP_ADMIN && YXORP_API_REQUEST && isset($bootManager['api'])) {
        $bootOrder = $bootManager['api'];
    }
    if (YXORP_ADMIN && !YXORP_API_REQUEST && isset($bootManager['ui'])) {
        $bootOrder = $bootManager['ui'];
    }
    if (!YXORP_ADMIN && !YXORP_API_REQUEST && isset($bootManager['lib'])) {
        $bootOrder = $bootManager['lib'];
    }
    if (YXORP_CLI && isset($bootManager['cli'])) {
        $bootOrder = $bootManager['cli'];
    }
    $moduleDirs = ['core' => YXORP_DIR . '/modules', 'addons' => YXORP_DIR . '/addons',];
    if ($customAddonDirs = $this->retrieve('loadmodules', null)) {
        $i = 1;
        foreach ($customAddonDirs as $dir) {
            $moduleDirs['custom' . $i++] = $dir;
        }
    }
    $modules = [];
    foreach ($moduleDirs as $type => $dir) {
        if (!file_exists($dir)) continue;
        foreach (new \DirectoryIterator($dir) as $module) {
            if ($module->isFile() || $module->isDot()) continue;
            if ($module->getBasename() == 'yxorP') continue;
            $modules[$module->getBasename()] = ['path' => $module->getRealPath(), 'type' => $type,];
        }
        if (!in_array($dir, (array)$this['autoload'])) {
            $this['autoload']->append($dir);
        }
    }
    foreach ($bootOrder as $module => $status) {
        if ($status == true && isset($modules[$module]['path'])) {
            $this->registerModule($module, $modules[$module]['path']);
        }
    }
}, 0);
$this('acl')->addResource('bootmanager', ['manage']);
if (YXORP_ADMIN && !YXORP_API_REQUEST) {
    include_once(__DIR__ . '/admin.php');
}