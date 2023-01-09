INSTALLATION
------------
0) define('YII_DEBUG', false); define('YII_ENV', 'prod');
1) setup db
2) composer install --ignore-platform-reqs
3) php yii setup-user
4) php yii setup-rbac
5) php yii rbac/migrate
6) php yii user/create login@domain.ru login password
7) php yii user/role/assign admin login@domain.ru
8) php yii setup-settings
9) php yii setup-queue
10) php yii migrate
11) chmod -vR 0777 runtime
    chmod -vR 0777 web/assets
    chmod -vR 0777 web/uploads
    chmod -vR 0755 yii
12) 