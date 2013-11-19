class nginx {
  package { "nginx":
    ensure => present
  }

  file { '/etc/nginx/sites-available/default':
    source => 'puppet:///modules/nginx/default',
    owner => 'root',
    group => 'root',
    require => Package['nginx']
  }

  service { "nginx":
    ensure => running,
    require => Package["nginx"]
  }
}
