#! /bin/sh

sudo apt-get update
sudo apt-get -y upgrade

# Install Git:
sudo apt-get -y install git

# Install Audio Driver:
sudo apt-get -y install libatlas-base-dev portaudio19-dev

# Install Python and required packages for it:
sudo apt-get -y install python3 python3-pip python3-scipy

# Fallback scipy module if the Pip module fails to install.

sudo apt-get -y install attr samba samba-common-bin samba-common
sudo apt-get -y install dnsmasq hostapd

curl -sSL https://raw.githubusercontent.com/TobKra96/music_led_strip_control/master/setup.sh | sudo bash -s -- -b dev_2.3


# etc/dnsmasq/dnsmasq.conf
# etc/hostapd/hostapd.conf
# etc/network/interfaces
# etc/samba/smb.conf
# etc/system/hostapd_cli.service
# etc/dhcpcd.conf
# etc/sysctl.conf
# bin/wsdd
# wsdd.service


sudo cp bin/wsdd /usr/local/bin/wsdd
sudo cp wsdd.service /etc/systemd/system/
sudo cp etc/system/hostapd_cli.service /etc/systemd/system/

sudo systemctl daemon-reload
sudo systemctl enable hostapd_cli.service
sudo systemctl enable wsdd.service

sudo systemctl start hostapd_cli.service
sudo systemctl start wsdd.service



