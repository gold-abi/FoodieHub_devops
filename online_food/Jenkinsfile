pipeline {
    agent any

    stages {
        stage('Clone Repo') {
            steps {
                git branch: 'main', url: 'https://github.com/gold-abi/FoodieHub_devops'
            }
        }

        stage('Build Docker Image') {
            steps {
                sh 'docker build -t abirami2006/food-app:latest .'
            }
        }

        stage('Push Image') {
            steps {
                sh 'docker push abirami2006/food-app:latest'
            }
        }

        stage('Deploy to Kubernetes') {
            steps {
                sh 'kubectl apply -f k8s/'
            }
        }
    }
}
