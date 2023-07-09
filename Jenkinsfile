pipeline {
  agent any
  
  stages {
    stage('Install Composer') {
  steps {
    sh 'curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer'
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
