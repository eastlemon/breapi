INSTALLATION
------------
0) define('YII_DEBUG', false); define('YII_ENV', 'prod');
1) setup db
2) composer install --ignore-platform-reqs
3) php yii setup-user
4) php yii setup-rbac
5) php yii rbac/migrate
6) php yii user/create admin@reapi.ru admin password
7) php yii user/role/assign admin admin@reapi.ru
8) php yii setup-settings
9) php yii setup-queue
10) php yii migrate