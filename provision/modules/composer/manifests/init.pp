class composer {

    package { "curl":
        ensure => present
    }

    package { "git-core":
        ensure => present
    }

    exec { "compose":
        command => '/bin/rm -rfv /var/www/repo/vendor/* && /bin/rm -f /var/www/repo/composer.lock && cd /var/www/repo && /usr/bin/curl -s http://getcomposer.org/installer | /usr/bin/php && /usr/bin/php /var/www/repo/composer.phar install',
        require => [ Package['curl'], Package['git-core'] ],
        creates => "/var/www/repo/composer.lock",
        timeout => 0
    }
}
