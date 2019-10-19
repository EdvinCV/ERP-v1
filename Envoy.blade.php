@servers(['aws' => 'ubuntu@18.188.255.223'])

@include('vendor/autoload.php')

@setup
    $origin = "git@github:EdvinCV/ERP-v1";
    $branch = isset($branch) ? $branch : "pruebaMaster";
    $app_dir = '/var/www/html';

    if(!isset($on)){
        throw new Exception('La variable --on no esta definida');
    }
@endsetup

@task('git:clone', ['on' => $on])
    cd {{ $app_dir }}
    echo "hemos entrado al directorio /var/www/html";
    git clone $origin;
    echo "repositorio clonado";
@endtask
@task('ls',['on'=> '$on'])
    cd {{ $app_dir }}
    ls -la
@endtask