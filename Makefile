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
	docker-compose build && docker-compose up

clean:
	docker-compose stop && docker-compose rm -f

rebuild:
	sudo rm -rf ./ynuosa-discuz/
	mkdir -p ./ynuosa-discuz/
	cp  ./xbtit/html/download.php ./ynuosa-xbtit/
	cp  ./xbtit/html/upload.php ./ynuosa-xbtit/
	cp -rf ./discuz/html/source/plugin/ynuosapt/* ./ynuosa-discuz/
	make start
	php rebuild.php
	sudo rm -rf ./discuz/html/*
	sudo rm -rf ./xbtit/html/*
	unzip ./src/Discuz_X3.2_SC_UTF8.zip -d discuz/html
	unzip ./src/xbtit.zip -d xbtit/html
	rm ./discuz/html/readme/ -rf
	rm ./discuz/html/utility/ -rf
	mv ./discuz/html/upload/* discuz/html/
	mv ./xbtit/html/xbtit/* xbtit/html/
	chmod 777 -R ./discuz/html/
	chmod 777 -R ./xbtit/html/
	cp -r ./ynuosa-discuz/ ./discuz/html/source/plugin/ynuosapt
	cp -f ./ynuosa-xbtit/* ./xbtit/html/

finish:
	sudo chmod 777 -R discuz/html/
	sudo chmod 777 -R xbtit/html/
	echo "['plugindeveloper'] = 2;" >> ./discuz/html/config/config_global.php