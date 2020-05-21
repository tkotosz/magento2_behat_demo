pipeline {
    agent { label "my127ws" }
    environment {
        MY127WS_KEY = credentials('magento2_behat_demo-my127ws-key')
        MY127WS_ENV = "pipeline"
    }
    triggers { cron(env.BRANCH_NAME == 'develop' ? 'H H(0-6) * * *' : '') }
    stages {
        stage('Build') {
            steps {
                sh 'ws install'
                milestone(10)
            }
        }
        stage('Test')  {
            parallel {
                stage('quality')    { steps { sh 'ws exec composer test-quality'    } }
                stage('unit')       { steps { sh 'ws exec composer test-unit'       } }
                stage('acceptance') { steps { sh 'ws exec composer test-acceptance' } }
                stage('helm kubeval qa')  { steps { sh 'ws helm kubeval qa' } }
            }
        }
    }
    post {
        always {
            sh 'ws destroy'
            cleanWs()
        }
    }
}
