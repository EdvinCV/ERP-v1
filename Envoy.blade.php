@servers(['aws' => 'ubuntu@18.188.255.223'])

@include('vendor/autoload.php')

@setup
    $origin = "git@github:EdvinCV/ERP-v1";
    $branch = isset($branch) ? $branch : "pruebaMaster";
    $app_dir = '/var/www/html';
@endsetup

@task('test')
    echo {{ $branch }}
@endtask
@task('ls',['on'=> 'aws'])
    cd {{ $app_dir }}
    ls -la
@endtask