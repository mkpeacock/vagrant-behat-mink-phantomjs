

if [ ! -f /usr/local/share/phantomjs-1.9.2-linux-x86_64/bin/phantomjs ]; then
   cd /usr/local/share && wget http://phantomjs.googlecode.com/files/phantomjs-1.9.2-linux-x86_64.tar.bz2 && tar xjf phantomjs-1.9.2-linux-x86_64.tar.bz2 && sudo ln -s /usr/local/share/phantomjs-1.9.2-linux-x86_64/bin/phantomjs /usr/local/share/phantomjs && sudo ln -s /usr/local/share/phantomjs-1.9.2-linux-x86_64/bin/phantomjs /usr/local/bin/phantomjs && sudo ln -s /usr/local/share/phantomjs-1.9.2-linux-x86_64/bin/phantomjs /usr/bin/phantomjs
   echo "Phantom JS Downloaded"
else
    echo "Phantom JS already downloaded"
fi

if ! ps aux | grep "[p]hantomjs" > /dev/null
then
    cd /usr/local/share
    echo "Starting Phantom JS"
    nohup phantomjs --webdriver=8643 --ignore-ssl-errors=yes 0<&- &>/dev/null &
    echo "Phantom JS started"
else
    echo "Phantom JS is already running"
fi
