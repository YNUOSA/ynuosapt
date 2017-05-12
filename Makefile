build:
	unzip src/Discuz_X3.2_SC_UTF8.zip -d discuz/html
	unzip src/xbtit.zip -d xbtit/html
	rm discuz/html/readme/ -rf
	rm discuz/html/utility/ -rf
	mv discuz/html/upload/* discuz/html/
	mv xbtit/html/xbtit/* xbtit/html/
start:
	sudo service apache2 stop
	sudo service mysql stop
	bash start_all.sh

clean:
	bash clean_all.sh

rebuild:
	sudo rm -rf /home/strrl/project/pt/ynuosa-discuz/
	mkdir -p /home/strrl/project/pt/ynuosa-discuz/
	cp  /home/strrl/project/pt/xbtit/html/download.php /home/strrl/project/pt/ynuosa-xbtit/
	cp  /home/strrl/project/pt/xbtit/html/upload.php /home/strrl/project/pt/ynuosa-xbtit/
	cp -rf /home/strrl/project/pt/discuz/html/source/plugin/ynuosapt/* /home/strrl/project/pt/ynuosa-discuz/
	make start
	php rebuild.php
	sudo rm -rf discuz/html/*
	sudo rm -rf xbtit/html/*
	unzip src/Discuz_X3.2_SC_UTF8.zip -d discuz/html
	unzip src/xbtit.zip -d xbtit/html
	rm discuz/html/readme/ -rf
	rm discuz/html/utility/ -rf
	mv discuz/html/upload/* discuz/html/
	mv xbtit/html/xbtit/* xbtit/html/
	chmod 777 -R discuz/html/
	chmod 777 -R xbtit/html/
	cp -r /home/strrl/project/pt/ynuosa-discuz/ /home/strrl/project/pt/discuz/html/source/plugin/ynuosapt
	cp -f /home/strrl/project/pt/ynuosa-xbtit/* /home/strrl/project/pt/xbtit/html/

finish:
	sudo chmod 777 -R discuz/html/
	sudo chmod 777 -R xbtit/html/
	echo "['plugindeveloper'] = 2;" >> /home/strrl/project/pt/discuz/html/config/config_global.php