group { 'puppet': ensure => 'present' }

import "nginx"
include nginx
import "php"
include php
import "composer"
include composer
import "mysql"
include mysql
import "mail"
include mail
