build:
	sudo rm -rf ./discuz/html/*
	sudo rm -rf ./xbtit/html/*
	unzip src/Discuz_X3.2_SC_UTF8.zip -d discuz/html
	unzip src/xbtit.zip -d xbtit/html
	rm discuz/html/readme/ -rf
	rm discuz/html/utility/ -rf
	mv discuz/html/upload/* discuz/html/
	mv xbtit/html/xbtit/* xbtit/html/
	sudo python copyfile.py
	sudo chmod 777 -R ./discuz/html/
	sudo chmod 777 -R ./xbtit/html/
	
start:
	sudo service apache2 stop
	sudo service mysql stop
	docker-compose build && docker-compose up -d

clean:
	docker-compose stop && docker-compose rm -f

rebuild:
	make start
	php rebuild.php
	make clean
	make build

finish:
	sudo chmod 777 -R discuz/html/
	sudo chmod 777 -R xbtit/html/
	echo "['plugindeveloper'] = 2;" >> ./discuz/html/config/config_global.php
