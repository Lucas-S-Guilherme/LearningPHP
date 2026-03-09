==> Summary
🍺  /home/linuxbrew/.linuxbrew/Cellar/php/8.5.2: 532 files, 168.7MB
==> Running `brew cleanup php`...
Disable this behaviour by setting `HOMEBREW_NO_INSTALL_CLEANUP=1`.
Hide these hints with `HOMEBREW_NO_ENV_HINTS=1` (see `man brew`).
==> Caveats
==> php
To enable PHP in Apache add the following to httpd.conf and restart Apache:
    LoadModule php_module /home/linuxbrew/.linuxbrew/opt/php/lib/httpd/modules/libphp.so

    <FilesMatch \.php$>
        SetHandler application/x-httpd-php
    </FilesMatch>

Finally, check DirectoryIndex includes index.php
    DirectoryIndex index.php index.html

The php.ini and php-fpm.ini file can be found in:
    /home/linuxbrew/.linuxbrew/etc/php/8.5/

To start php now and restart at login:
  brew services start php
Or, if you don't want/need a background service you can just run:
  /home/linuxbrew/.linuxbrew/opt/php/sbin/php-fpm --nodaemonize


--- 03/03/2026

==> Next steps:
- Run these commands in your terminal to add Homebrew to your PATH:
    echo >> /home/lucasguilherme/.zshrc
    echo 'eval "$(/home/linuxbrew/.linuxbrew/bin/brew shellenv zsh)"' >> /home/lucasguilherme/.zshrc
    eval "$(/home/linuxbrew/.linuxbrew/bin/brew shellenv zsh)"
- Install Homebrew's dependencies if you have sudo access:
    sudo apt-get install build-essential