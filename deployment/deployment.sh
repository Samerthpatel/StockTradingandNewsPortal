#!/bin/bash

read -p "Do you want to deploy or rollback? (deploy,rollback): " one
case "$one" in
	"deploy" )
	read -p "What do you want to deploy? (database,frontend,dmz): " two
	read -p "Where do you want to deploy? (qa,production): " three
	case "$two" in
		"database" )
			case "$three" in
				"qa" )
				variable=1
				cd /home/parallels/Desktop/deployment/database/
				while : 
				do
					if [ ! -d "database_$variable" ]; then
						mkdir "database_$variable"
						cd database_$variable
						sshpass -p "samerthpatel" scp -r parallels@192.168.192.122:/home/parallels/Desktop/database/database/* ./
						sshpass -p "samerthpatel" scp -r /home/parallels/Desktop/deployment/database/database_$variable/* parallels@192.168.192.95:/home/parallels/Desktop/database/database/
						echo samerthpatel | ssh -tt parallels@192.168.192.95 sudo systemctl restart databaseserver
						echo "database package version $variable deployed to QA"
						read -p "Is this version passing: " pass
						case "$pass" in
						"yes" )
						stable=passing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./databasepass.php $variable
						echo "database version $variable added to database as passing"
						;;
						"no" )
						stable=failing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./databasefail.php $variable
						echo "database version $variable added to database as failing"
						esac
						break
					else
						let "variable=variable+1"
					fi
				done
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				database=$(cat /home/parallels/Desktop/rabbitmqphp_example/database.txt)
				cd /home/parallels/Desktop/deployment/database/database_$database
				sshpass -p "samerthpatel" scp -r /home/parallels/Desktop/deployment/database/database_$database/* parallels@192.168.192.22:/home/parallels/Desktop/database/database/
				echo samerthpatel | ssh -tt parallels@192.168.192.22 sudo systemctl restart databaseserver
				echo "databse package version $database deployed to Production"
				;;
			esac
		;;
		"frontend" )
			case "$three" in
				"qa" )
				version=1
				cd /home/parallels/Desktop/deployment/website/
				while : 
				do
					if [ ! -d "website_$version" ]; then
						mkdir "website_$version"
						cd website_$version
						sshpass -p "Radiarishi17" scp -r rishi@192.168.192.178:/home/rishi/Desktop/website/website/* ./
						sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$version/* rishi@192.168.192.252:/home/rishi/Desktop/website/website/
						echo password | ssh -tt rishi@192.168.192.252 sudo chmod -R 777 /var/www/html/
						sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$version/* rishi@192.168.192.252:/var/www/html/website/website/
						echo password | ssh -tt rishi@192.168.192.252 sudo service apache2 restart
						echo "website package version $version deployed to QA"
						read -p "Is this version passing: " pass
						case "$pass" in
						"yes" )
						stable=passing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./frontendpass.php $version
						echo "frontend version $version added to database as passing"
						;;
						"no" )
						stable=failing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./frontendfail.php $version
						echo "frontend version $version added to database as passing"
						esac
						break
					else
						let "version=version+1"
					fi
				done
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				frontend=$(cat /home/parallels/Desktop/rabbitmqphp_example/frontend.txt)
				cd /home/parallels/Desktop/deployment/website/website_$frontend
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$frontend/* rishi@192.168.192.97:/home/rishi/Desktop/website/website/
				echo password | ssh -tt rishi@192.168.192.97 sudo chmod -R 777 /var/www/html/
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$frontend/* rishi@192.168.192.97:/var/www/html/website/website/
				echo password | ssh -tt rishi@192.168.192.97 sudo service apache2 restart
				echo "website package version $frontend deployed to Production"
				;;
			esac
		;;
		"dmz" )
			case "$three" in
				"qa" )
				var=1
				cd /home/parallels/Desktop/deployment/dmz/
				while : 
				do
					if [ ! -d "dmz_$var" ]; then
						mkdir "dmz_$var"
						cd dmz_$var
						sshpass -p "passwordit490" scp -r prince@192.168.192.39:/home/prince/Desktop/dmz/dmz/* ./
						sshpass -p "passwordit490" scp -r /home/parallels/Desktop/deployment/dmz/dmz_$var/* prince@192.168.192.90:/home/prince/Desktop/dmz/dmz/
						echo passwordit490 | ssh -tt prince@192.168.192.90 sudo systemctl restart dmzserver
						echo "dmz package version $var deployed to QA"
						read -p "Is this version passing: " pass
						case "$pass" in
						"yes" )
						stable=passing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./dmzpass.php $var
						echo "dmz version $var added to database as passing"
						;;
						"no" )
						stable=failing
						cd /home/parallels/Desktop/rabbitmqphp_example/
						./dmzfail.php $var
						echo "dmz version $var added to database as passing"
						esac
						break
					else
						let "var=var+1"
					fi
				done
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php $var
				dmz=$(cat /home/parallels/Desktop/rabbitmqphp_example/dmz.txt)
				cd /home/parallels/Desktop/deployment/dmz/dmz_$dmz
				sshpass -p "passwordit490" scp -r /home/parallels/Desktop/deployment/dmz/dmz_$dmz/* prince@192.168.192.26:/home/prince/Desktop/dmz/dmz/
				echo passwordit490 | ssh -tt prince@192.168.192.26 sudo systemctl restart dmzserver
				echo "dmz package version $dmz deployed to Production"
				;;
			esac
		;;
	esac
	;;
	"rollback" )
	read -p "What do you want to rollback? (database,frontend,dmz): " four
	read -p "Where do you want to rollback? (qa,production): " five
	case "$four" in 
		"database" )
			case "$five" in
				"qa" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				database=$(cat /home/parallels/Desktop/rabbitmqphp_example/database.txt)
				cd /home/parallels/Desktop/deployment/database/database_$database
				sshpass -p "samerthpatel" scp -r /home/parallels/Desktop/deployment/database/database_$database/* parallels@192.168.192.95:/home/parallels/Desktop/database/database/
				echo samerthpatel | ssh -tt parallels@192.168.192.95 sudo systemctl restart databaseserver
				echo "database package rolled back to version $database on QA"
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				database=$(cat /home/parallels/Desktop/rabbitmqphp_example/database.txt)
				cd /home/parallels/Desktop/deployment/database/database_$database
				sshpass -p "samerthpatel" scp -r /home/parallels/Desktop/deployment/database/database_$database/* parallels@192.168.192.22:/home/parallels/Desktop/database/database/
				echo samerthpatel | ssh -tt parallels@192.168.192.22 sudo systemctl restart databaseserver
				echo "database package rolled back to version $database on production"
				;;
			esac
		;;
		"frontend" )
			case "$five" in
				"qa" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				frontend=$(cat /home/parallels/Desktop/rabbitmqphp_example/frontend.txt)
				cd /home/parallels/Desktop/deployment/website/website_$frontend
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$frontend/* rishi@192.168.192.252:/home/rishi/Desktop/website/website/
				echo password | ssh -tt rishi@192.168.192.252 sudo chmod -R 777 /var/www/html/
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$frontend/* rishi@192.168.192.252:/var/www/html/website/website/
				echo password | ssh -tt rishi@192.168.192.252 sudo service apache2 restart
				echo "frontend package rolled back to version $frontend on QA"
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				frontend=$(cat /home/parallels/Desktop/rabbitmqphp_example/frontend.txt)
				cd /home/parallels/Desktop/deployment/website/website_$frontend
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$website/* rishi@192.168.192.97:/home/rishi/Desktop/website/website/
				echo password | ssh -tt rishi@192.168.192.97 sudo chmod -R 777 /var/www/html/
				sshpass -p "password" scp -r /home/parallels/Desktop/deployment/website/website_$website/* rishi@192.168.192.97:/var/www/html/website/website/
				echo password | ssh -tt rishi@192.168.192.97 sudo service apache2 restart
				echo "frontend package rolled back to version $frontend on production"
				;;
			esac
		;;
		"dmz" )
			case "$five" in
				"qa" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				dmz=$(cat /home/parallels/Desktop/rabbitmqphp_example/dmz.txt)
				cd /home/parallels/Desktop/deployment/dmz/dmz_$dmz
				sshpass -p "passwordit490" scp -r /home/parallels/Desktop/deployment/dmz/dmz_$dmz/* prince@192.168.192.90:/home/prince/Desktop/dmz/dmz/
				echo passwordit490 | ssh -tt prince@192.168.192.90 sudo systemctl restart dmzserver
				echo "dmz package rolled back to version $dmz on QA"
				;;
				"production" )
				cd /home/parallels/Desktop/rabbitmqphp_example/
				./production.php
				dmz=$(cat /home/parallels/Desktop/rabbitmqphp_example/dmz.txt)
				cd /home/parallels/Desktop/deployment/dmz/dmz_$dmz
				sshpass -p "passwordit490" scp -r /home/parallels/Desktop/deployment/dmz/dmz_$dmz/* prince@192.168.192.26:/home/prince/Desktop/dmz/dmz/
				echo passwordit490 | ssh -tt prince@192.168.192.26 sudo systemctl restart dmzserver
				echo "dmz package rolled back to version $dmz on production"
				;;
			esac
		;;
	esac
	;;
esac
