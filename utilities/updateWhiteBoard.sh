#!/bin/sh
#
clear

echo 'Instalando Whiteboard ...'
echo 'Realizando o download do codigo ...'

#Pegando os arquivos atualizados
svn co http://whiteboard.inf.poa.ifrs.edu.br/svn/repository/whiteboard/main/whiteBoard/

#Salvando o diretorios que não serão alterados
mv www/midiateca /var
mv www/mysql /var
mv www/red5 /var
mv www/redmine /var
mv www/eduquito /var
mv www/node/WhiteBoardLog /var

#Limpa o diretorio do quadro branco para receber novo arquivos
rm -rf /var/www/*

#move os arquivos para o diretorio principal
mv whiteBoard/* /var/www

#Remove os arquivos desatualizados da pasta recem baixada
rm -rf www/mysql
rm -rf www/midiateca
rm -rf www/red5
rm -rf www/redmine
rm -rf www/eduquito

#Adiciona os arquivos salvos anteriormente
mv mysql /var/www
mv midiateca /var/www
mv red5 /var/www
mv redmine /var/www
mv eduquito /var/www
mv WhiteBoardLog /var/www/node

#Remove o diretorio provisorio vazio 
rm -rf whiteBoard

#Direciona o websocket para o servidor do quadro branco
sed -i 's/localhost/whiteboard.inf.poa.ifrs.edu.br/g' www/pages/bases/javascript/application.js

#Instala a nova base de dados
echo 'Instalando a nova base de dados'

mysql --user=wb --password=wb  whiteboard < www/sql/schema.sql
mysql --user=wb --password=wb  whiteboard < www/sql/data/user.sql

#Mata o processo do whiteboard se já houver um
wb=`pgrep -f WhiteBoardServer`
if test "$wb" != ""
then
        kill $wb
fi

#Cria um arquivo de log baseado na data atual
NOW=$(date +"%F %T")

LOGFILE="WhiteBoard-$NOW.log"

#Liga o nodejs
nohup node /var/www/node/WhiteBoardServer.js > /var/www/node/WhiteBoardLog/$LOGFILE &

#Mata o processo do red5 se já houver um
red5=`pgrep -f /usr/bin/java`
if test "$red5" != ""
then
        kill $red5
fi

#Liga o red5
cd www/red5/

nohup sh red5.sh &

#THE END
echo 'Instalacao concluida!'
