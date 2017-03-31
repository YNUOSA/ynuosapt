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