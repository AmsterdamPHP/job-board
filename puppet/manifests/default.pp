# Basic Puppet manifest

Exec { path => [ "/bin/", "/sbin/" , "/usr/bin/", "/usr/sbin/" ] }

class system-update {
  exec { 'apt-get update':
    command => 'apt-get update',
  }

  $sysPackages = [ "build-essential" ]
  package { $sysPackages:
    ensure => "installed",
    require => Exec['apt-get update'],
  }
}
class base-server {

  $devPackages = [ "git", "openssh-server", "dstat", "bmon", "joe", "xz-utils", "rar" ]
  package { $devPackages:
    ensure => "installed",
    require => Exec['apt-get update'],
  }

}

class development {

  $devPackages = [ "curl" , "memcached" , "ssmtp" ]
  package { $devPackages:
    ensure => "installed",
    require => [ Class[ 'system-update' ],Class[ 'base-server' ] ],
  }
}

class lamp {

  $devPackages = [ "lamp-server^", "php-pear", "php5-xdebug", "php-cache-lite", "php5-memcache", "php5-curl", "php-apc",
                    "phpmyadmin", "php5-intl", "mysql-server", "mysql-client", "php5-mysql" ]
  package { $devPackages:
    ensure => "installed",
    require => Class[ 'development' ],
    before => Exec[ 'apache enable module' ]
  }

  file { '/var/www/vagrant':
    ensure => 'link',
    owner  => "vagrant",
    group  => "vagrant",
    mode   => 777,
    target => '/vagrant/www/web',
    require => Package[ 'lamp-server^' ],
  }

  exec { 'apache enable module':
    command => 'a2enmod headers deflate rewrite',
  }
  exec { 'Apache restart':
    command => '/etc/init.d/apache2 restart',
    require => Exec[ 'apache enable module' ]
  }

  file { '/etc/apache2/sites-enabled/001-phpmyadmin':
      ensure => 'link',
      owner  => "vagrant",
      group  => "vagrant",
      mode   => 777,
      target => '/etc/phpmyadmin/apache.conf',
      require => Package[ 'phpmyadmin' ],
    }

  exec { "set-mysql-password":
    unless  => "mysql -uroot -proot",
    path    => ["/bin", "/usr/bin"],
    command => "mysqladmin -uroot password root",
  }

  exec { "create-database":
    unless  => "/usr/bin/mysql -ujobs -psymfony jobboard",
    command => "/usr/bin/mysql -uroot -proot -e \"create database jobboard; grant all on jobboard.* to jobs@localhost identified by 'jobs';\"",
  }
  exec { "set-mysql-password":
    unless  => "mysql -uroot -proot",
    path    => ["/bin", "/usr/bin"],
    command => "mysqladmin -uroot password root",
  }

}

class phppackages{

  exec { 'PEAR upgrade':
    command => 'pear upgrade PEAR',
    require => Class[ 'lamp' ]
  }
  exec { 'PEAR autodiscover':
    command => 'pear config-set auto_discover 1',
    require => Exec[ 'PEAR upgrade' ]
  }
  exec { 'PEAR discover PHPMD':
    command => 'pear channel-discover pear.phpmd.org',
    require => Exec[ 'PEAR autodiscover' ]
  }

  exec { 'PEAR install phpunit':
    command => 'pear install pear.phpunit.de/PHPUnit',
    require => Exec[ 'PEAR autodiscover' ]
  }
  exec { 'PEAR dbunit':
    command => 'pear install phpunit/DbUnit',
    require => Exec[ 'PEAR install phpunit' ]
  }
  exec { 'PEAR PHPUnit selenium':
    command => 'pear install phpunit/PHPUnit_Selenium',
    require => Exec[ 'PEAR install phpunit' ]
  }
  exec { 'PEAR PHPMD':
    command => 'pear install phpmd/PHP_PMD',
    require => Exec[ 'PEAR discover PHPMD' ]
  }
}


include system-update

include base-server

include development

include lamp

include phppackages


