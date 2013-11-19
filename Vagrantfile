# -*- mode: ruby -*-
# vi: set ft=ruby :

Vagrant.configure("2") do |config|

  config.vm.box = "quantal64"
  config.vm.box_url = "http://cloud.github.com/downloads/roderik/VagrantQuantal64Box/quantal64.box"

  config.vm.network :forwarded_port, guest: 80, host: 8080

  config.vm.synced_folder ".", "/var/www/repo"

  config.vm.provision :shell, :path => "provision/prepare.sh"
  config.vm.provision :puppet do |puppet|
    puppet.manifests_path = "provision/manifests"
    puppet.manifest_file  = "vagrant.pp"
    puppet.module_path = "provision/modules"
  end
  config.vm.provision :shell, :path => "provision/post-puppet.sh"

end
