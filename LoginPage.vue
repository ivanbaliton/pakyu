<template>
    <ion-page>
        <ion-header :translucent="true">
            <ion-toolbar>
                <ion-title>Login</ion-title>
            </ion-toolbar>
        </ion-header>

        <ion-content :fullscreen="true">
            <div id="signup-container">
                <h1>Welcome Back!</h1>
               
                    <ion-item class="input-item">
                        
                        <ion-input
                            v-model="credentials.username"
                            label="Username"
                            label-placement="floating"
                            type="text"
                            required
                            
                        ></ion-input>
                    </ion-item>
                   

                    <ion-item class="input-item">
                        
                        <ion-input
                            v-model="credentials.password"
                            label="Password"
                            label-placement="floating"
                            type="password"
                            required
                            
                        ></ion-input>
                    </ion-item>
                    

                    <ion-button @click="handleLogin"expand="block"   class="signup-button">
                        <ion-spinner v-if="isLoading" slot="start"></ion-spinner>
                        Login
                    </ion-button>
                
                <p class="redirect-text">
                    Don't have an account? <a @click.prevent="redirectToSignup">Sign-up</a>
                </p>

               
            </div>
        </ion-content>
    </ion-page>
</template>

<script setup lang="ts">
import {
    IonContent,
    IonHeader,
    IonPage,
    IonTitle,
    IonToolbar,
    IonItem,
    IonLabel,
    IonInput,
    IonButton,
    IonSpinner,
} from '@ionic/vue';
import axios from 'axios';
import { ref } from 'vue';
import { useRouter } from 'vue-router';

const credentials = ref({
    username: "",
    password: "",
});



const isLoading = ref(false);

const router = useRouter();

const handleLogin = async () => {
    isLoading.value = true;

    if (credentials.value.username === "") {
        alert("Please enter your username");
        isLoading.value = false;
    } else if (credentials.value.password === "") {
        alert("Please enter your password");
        isLoading.value = false;
    } else {
        axios.post("http://localhost/login_signup/Login.php", {
            username: credentials.value.username,
            password: credentials.value.password,
    })
    .then(response => {
      if (response.data.success) {
        
        router.push('/home');
      } else {
        alert("Invalid credentials");
       
        
      }
    })
    .catch(error => {
      console.error("There was an error logging in!", error);
    })
    .finally(() => {
        isLoading.value = false;
    });

    }
};


    
        




const redirectToSignup = () => {
    router.push('/signup'); // Replace '/signup' with the actual route to your signup page
};


</script>

<style scoped>
#signup-container {
    max-width: 500px;
    margin: 30px auto; /* Added top margin to lower the container */
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

.error-message {
    color: red;
    font-size: 14px;
    margin-top: -10px;
    margin-bottom: 10px;
    text-align: left;
}

.input-error {
    border: 1px solid red;
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
