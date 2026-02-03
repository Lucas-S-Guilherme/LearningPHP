Upgrading from MySQL <8.4 to MySQL >9.0 requires running MySQL 8.4 first:
 - brew services stop mysql
 - brew install mysql@8.4
 - brew services start mysql@8.4
 - brew services stop mysql@8.4
 - brew services start mysql

We've installed your MySQL database without a root password. To secure it run:
    mysql_secure_installation

MySQL is configured to only allow connections from localhost by default

To connect run:
    mysql -u root

To start mysql now and restart at login:
  brew services start mysql
Or, if you don't want/need a background service you can just run:
  /home/linuxbrew/.linuxbrew/opt/mysql/bin/mysqld_safe --datadir\=/home/linuxbrew/.linuxbrew/var/mysql
==> Summary
🍺  /home/linuxbrew/.linuxbrew/Cellar/mysql/9.6.0: 338 files, 356.6MB
==> Running `brew cleanup mysql`...
Disable this behaviour by setting `HOMEBREW_NO_INSTALL_CLEANUP=1`.
Hide these hints with `HOMEBREW_NO_ENV_HINTS=1` (see `man brew`).
==> Caveats
==> mysql
Upgrading from MySQL <8.4 to MySQL >9.0 requires running MySQL 8.4 first:
 - brew services stop mysql
 - brew install mysql@8.4
 - brew services start mysql@8.4
 - brew services stop mysql@8.4
 - brew services start mysql

We've installed your MySQL database without a root password. To secure it run:
    mysql_secure_installation

MySQL is configured to only allow connections from localhost by default

To connect run:
    mysql -u root

To start mysql now and restart at login:
  brew services start mysql
Or, if you don't want/need a background service you can just run:
  /home/linuxbrew/.linuxbrew/opt/mysql/bin/mysqld_safe --datadir\=/home/linuxbrew/.linuxbrew/var/mysql