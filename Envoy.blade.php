@servers(['aws' => 'ubuntu@18.188.255.223'])

@include('vendor/autoload.php')

@setup
    $branch = isset($branch) ? $branch : "pruebaMaster";
@endsetup

@task('test')
    echo {{ $branch }}
@endtask
@task('ls',['on'=> 'aws'])
    cd /var/www/html
    ls -la
@endtask