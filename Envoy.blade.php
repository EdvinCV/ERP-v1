@servers(['aws' => 'ubuntu@18.188.255.223'])

@include('vendor/autoload.php')

@setup
    $origin = 'git@github.com:EdvinCV/ERP-v1';
    $branch = isset($branch) ? $branch : "pruebaMaster";
    $app_dir = '/var/www/html/ERP-v1';

    if(!isset($on)){
        throw new Exception('La variable --on no esta definida');
    }
@endsetup

@task('git:clone', ['on' => $on])
    cd {{ $app_dir }}
    echo "hemos entrado al directorio /var/www/html";
    git clone {{ $origin }};
    echo "repositorio clonado";
@endtask
@task('git:pull', ['on' => $on])
    cd {{ $app_dir }}
    echo "hemos entrado al directorio {{ $app_dir }}";
    git pull origin {{ $branch }}
    echo "codigo actualizado";
@endtask
@task('ls',['on'=> $on])
    cd {{ $app_dir }}
    ls -la
@endtask
@task('composer:install',['on'=> $on])
    cd {{ $app_dir }}
    composer install
@endtask
@task('key:generate',['on'=> $on])
    cd {{ $app_dir }}
    php artisan key:generate
@endtask