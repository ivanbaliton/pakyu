<template>
    <ion-page>
        <ion-header :translucent="true">
            <ion-toolbar>
                <ion-title>Sign Up</ion-title>
            </ion-toolbar>
        </ion-header>

        <ion-content :fullscreen="true">
            <div id="signup-container">
                <h1>Create Your Account</h1>
               
                    <ion-item lines="full" class="input-item">
                        
                        <ion-input 
                            v-model="signupData.username" 
                            label="Username"
                            label-placement="floating"
                            type="text" 
                            required>
                        </ion-input>
                    </ion-item>

                    <ion-item lines="full" class="input-item">
                        
                        <ion-input
                             v-model="signupData.email"
                            label="Email"
                            label-placement="floating"
                            type="email" 
                            required>
                        </ion-input>
                    </ion-item>

                    <ion-item lines="full" class="input-item">
                        
                        <ion-input 
                            v-model="signupData.password" 
                            label="Password"
                            label-placement="floating"
                            type="password" 
                            required></ion-input>
                    </ion-item>
                    <ion-item lines="full" class="input-item">
                       
                        <ion-input 
                            v-model="signupData.confirmPassword" 
                            label="Confirm Password"
                            label-placement="floating"
                            type="password" 
                            required>
                        </ion-input>
                    </ion-item>
                    <ion-button expand="block" @click="handleSignup" class="signup-button">Sign Up</ion-button>
            
                <p class="redirect-text">
                    Already have an account? <a @click.prevent="redirectToLogin">Login</a>
                </p>

               


            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import { IonContent, IonHeader, IonPage, IonTitle, IonToolbar, IonItem, IonLabel, IonInput, IonButton } from '@ionic/vue';
import { ref } from 'vue';
import { useRouter } from 'vue-router';
import { api } from "../global";
import axios from 'axios';


const signupData = ref({
    username: "",
    email: "",
    password: "",
    confirmPassword: ""
});

const router = useRouter();

const handleSignup = () => {
   if(signupData.value.username == "") { 
        alert("Please enter a username");
    }
    else if(signupData.value.email == "") { 
        alert("Please enter an email address");
    }
    else if(signupData.value.password == "") { 
        alert("Please enter a password");
    }
    else if(signupData.value.confirmPassword == "") { 
        alert("Please confirm your password");
    }
    else if(signupData.value.password !== signupData.value.confirmPassword) {
        alert("Passwords do not match");
    } else {
        if(signupData.value.password == signupData.value.confirmPassword) {
            
            axios.post("http://localhost/login_signup/Signup.php", {
                username: signupData.value.username,
                email: signupData.value.email,
                password: signupData.value.password
            })
            .then((response) => {
                if(response.data.status == "success") {
                    alert("Signup successful! ");
                    router.push('/login');
                } else {
                    alert("Signup failed. Please try again.");
                }
            })
            .catch((error) => {
                console.error("There was an error during the signup process:", error);
                alert("An error occurred. Please try again later.");
            });
        }
        else {
            alert("Passwords do not match");
        }
        
    }

    
};

const redirectToLogin = () => {
    router.push('/login');
};


</script>

<style scoped>
#signup-container {
    max-width: 500px;
    margin: 30px auto;
    padding: 30px;
    text-align: center;
    background: linear-gradient(145deg, #ffffff, #f0f0f0);
    border-radius: 16px;
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
    animation: fadeIn 0.5s ease-in-out;
}

h1 {
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 25px;
    color: #222;
}

ion-item {
    --background: transparent;
    --border-radius: 8px;
}

.input-item {
    margin-bottom: 20px;
    --highlight-color-focused: #4caf50;
}

.signup-button {
    margin-top: 25px;
    --background: #4caf50;
    --background-hover: #43a047;
    --background-activated: #388e3c;
    --color: #fff;
    border-radius: 12px;
    font-size: 16px;
    font-weight: bold;
    padding: 12px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.redirect-text {
    margin-top: 20px;
    font-size: 14px;
    color: #555;
}

.redirect-text a {
    color: #4caf50;
    text-decoration: none;
    font-weight: bold;
    transition: color 0.3s ease;
}

.redirect-text a:hover {
    color: #388e3c;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
