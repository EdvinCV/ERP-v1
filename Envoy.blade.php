@servers(['aws' => 'ubuntu@18.188.255.223'])

@include('vendor/autoload.php')

@task('test')
    echo "tarea ejecutada"
@endtask
@task('ls',{'on'=> 'aws'})
    cd /var/www/html
    ls -la
@endtask