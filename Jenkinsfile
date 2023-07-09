pipeline {
  agent any
  
  stages {
    stage('Install PHP and Composer') {
      steps {
        sh ' apt update'
        sh ' apt install -y php-cli'
        sh 'php -r "copy(\'https://getcomposer.org/installer\', \'composer-setup.php\');"'
        sh 'php composer-setup.php'
        sh 'php -r "unlink(\'composer-setup.php\');"'
        sh ' mv composer.phar /usr/local/bin/composer'
      }
    }
    stage('Build and Test') {
      steps {
        dir('AmenBank/AmenBank') {
          // Change the working directory to your project folder
          
          // Install Composer dependencies
          sh 'composer install'
          
          // Run PHPUnit tests
          sh 'vendor/bin/phpunit'
          
          // Build the Symfony application
          sh 'php bin/console cache:clear --env=prod'
          sh 'php bin/console assets:install --env=prod'
          sh 'php bin/console assetic:dump --env=prod'
        }
      }
    }
  }
}
