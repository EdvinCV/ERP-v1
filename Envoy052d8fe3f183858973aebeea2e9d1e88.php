<?php $__container->servers(['aws' => 'ubuntu@18.188.255.223']); ?>

 <?php require_once('vendor/autoload.php'); ?>

<?php $__container->startTask('test'); ?>
    echo "tarea ejecutada"
<?php $__container->endTask(); ?>
<?php $__container->startTask('ls',{'on'=> 'aws'}); ?>
    cd /var/www/html
    ls -la
<?php $__container->endTask(); ?>