Стек технологий:

PHP 7.2, Laravel
Postgresql - в качестве основной базы
Redis - в качестве очереди сообщений

К проекту прилагается веб интерфейс для удобного тестирования функционала. В нем можно:
1. Добавить юзера
2. Увидеть список юзеров с балансами и возмодными операциями (add, minus, hold)
3. Увидеть список hold операций
4. Возможность применить approve, decline к hold операциям
5. Создать операцию transfer для трансфера денег между 2-мя юзерами

Установка:

1. Берем свежий homestead образ и разворачиваем в вагранте
https://laravel.com/docs/5.6/homestead
2. Донастраиваем homestaed.yaml на новый сайт, добавляя следующие директивы:

folders:
    - map: D:/wamp/vhosts/laravel/iqoption/gui
      to: /home/vagrant/gui

sites:
    - map: gui.test
      to: /home/vagrant/gui/iq/public

В folders в map указываем вашу локальную папку где вы разрабатываете, на которую будет маппинг папки внутри виртуалки

3. Прописываем в файле hosts:
    192.168.10.10	gui.test
4. vagrant up
5. Заходим на виртуалку через vagrant ssh
6. Создаем папку проекта
mkdir /home/vagrant/gui
7. Скачиваем проект с Github:
git init
git clone -b master https://github.com/Gegirhasut/iq.git

**Внимание!** В проект закомичен файл .env, поэтому с ним никаких манипуляций делать не нужно.

8. Устанавливаем зависимости:
composer install
9. Создаем юзера и базу в postgresql (они уже прописаны в env):
sudo -u postgres psql -c "create role micro with login password 'micro';"
sudo -u postgres psql -c "alter role micro CREATEDB;"
sudo -u postgres psql -c "create database micro;"
10. Запускаем очередь
/home/vagrant/gui/iq
php artisan queue:listen
11. Идем через браузер на http://gui.test
12. Добавляем юзеров, совершаем с ними остальные операции

![Вот так это выглядит](https://raw.githubusercontent.com/Gegirhasut/iq/master/example.PNG)