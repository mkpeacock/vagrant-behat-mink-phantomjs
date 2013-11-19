class php {

  package { "php5-fpm":
    ensure => present
  }

  service { "php5-fpm":
    ensure => running,
    require => Package["php5-fpm"],
    notify => Service["nginx"]
  }

  package { "php5-mysql":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-dev":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-curl":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-gd":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-imagick":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-mcrypt":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-mhash":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-pspell":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-snmp":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-xmlrpc":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-xsl":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php5-cli":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  package { "php-pear":
    ensure => present,
    notify => Package["php5-fpm"]
  }

  exec { "testing-and-qa":
    command => "/usr/bin/pear upgrade pear && /usr/bin/pear config-set auto_discover 1 && /usr/bin/pear install pear.phpunit.de/PHPUnit && /usr/bin/pear install PHP_CodeSniffer && /usr/bin/pear install pear.phpunit.de/phpcpd && /usr/bin/pear channel-discover pear.pdepend.org && /usr/bin/pear install pdepend/PHP_Depend-beta && /usr/bin/pear install pear.phpunit.de/phploc && /usr/bin/pear channel-discover pear.phpmd.org && /usr/bin/pear install --alldeps phpmd/PHP_PMD && /usr/bin/git clone https://github.com/klaussilveira/phpcs-psr /usr/share/php/PHP/CodeSniffer/Standards/PSR",
    require => Package[php-pear],
    timeout => 0,
    returns => [0,1]
  }

}
