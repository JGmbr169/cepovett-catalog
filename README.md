# TEST TECHNIQUE PHP SYMFONY

## Stacks

php 8.1.28, mysql 8.3.0, symfony 6.4.9, npm 8.19.2, composer 2.2.24

## Commandes à exécuter

`
php bin/console make:migration
`

`
php bin/console doctrine:migrations:migrate
`

`
php bin/console doctrine:fixtures:load
`

## Création utilisateur

`
php bin/console app:create-user username password --roles="ROLE_CLIENT"
`

`
php bin/console app:create-user username password --roles="ROLE_ADMIN"
`

## Vhost

Modifier le fichier **httpd-vhosts.conf**

```
<VirtualHost *:80>
   ServerName site.local
   DocumentRoot "<PATH_FILES>"
   <Directory "<PATH_FILES>/">
      Options +Indexes +Includes +FollowSymLinks +MultiViews
      AllowOverride All
      Require local
   </Directory>
</VirtualHost>
```

Modifier le fichier **hosts**

```
127.0.0.1 site.local
```

## Authors

- [@JGmbr169](https://github.com/JGmbr169)