<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h2 class="text-center">Register</h2>
            <form @submit.prevent="registerUser" class="form-horizontal padding-md">
              <div class="form-group mt-3">
                <label>Name</label>
                <input type="text" v-model="name" class="form-control" placeholder="Enter Name" name="name" id="name"
                  required />
              </div>
              <div class="form-group mt-2">
                <label>Email</label>
                <input type="email" v-model="email" class="form-control" placeholder="Enter Email" name="email" id="email"
                  required />
              </div>
              <div class="form-group mt-2">
                <label for="password">Password</label>
                <div class="input-group">
                <input :type="showPassword ? 'text' : 'password'" v-model="password" class="form-control"
                  placeholder="Enter Password" required />
                <div class="input-group-append">
                  <button class="btn btn-outline-secondary" type="button" @click="togglePasswordVisibility">
                    <i :class="showPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                  </button>
                </div>
              </div>
          </div>
          <div class="form-group mt-2">
            <label for="password">Confirm Password</label>
            <div class="input-group">
              <input :type="showConfirmPassword ? 'text' : 'password'" v-model="confirm_password" class="form-control"
                placeholder="Confirm Password" name="confirm_password" id="confirm_password" required />
              <div class="input-group-append">
                <button class="btn btn-outline-secondary" type="button" @click="toggleConfirmPasswordVisibility">
                  <i :class="showConfirmPassword ? 'bi bi-eye-slash' : 'bi bi-eye'"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="form-group mt-3">
            <div class="d-grid gap-2">
              <button type="submit" class="btn btn-primary" :disabled="loading">
                <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                <span v-else>Register</span>
              </button>
            </div>
          </div>

          <div v-if="errorMessage" class="alert alert-danger mt-3" role="alert">
            {{ errorMessage }}
          </div>
          <div v-if="successMessage" class="alert alert-success mt-3" role="alert">
            {{ successMessage }}
          </div>
          </form>

          <p class="mt-3 text-center">
            Sudah punya akun?
            <router-link to="/login">Login</router-link>
          </p>
        </div>
      </div>
    </div>
  </div>
</div></template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      name: '',
      email: '',
      password: '',
      confirm_password: '',
      loading: false,
      errorMessage: '',
      successMessage: '',
      showPassword: false,
      showConfirmPassword: false,
    };
  },
  methods: {
    registerUser() {
      if (this.password !== this.confirm_password) {
        this.errorMessage = 'Passwords do not match';
        return;
      }

      this.loading = true;
      axios
        .post('http://localhost:8000/api/register', {
          name: this.name,
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          console.log(response.data);
          this.errorMessage = '';
          this.successMessage = response.data.message;
          this.$router.push({ name: 'register' });
        })
        .catch((error) => {
          console.error(error.response.data);
          this.successMessage = '';
          this.errorMessage = error.response.data.error;
        })
        .finally(() => {
          this.loading = false;
        });
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
    toggleConfirmPasswordVisibility() {
      this.showConfirmPassword = !this.showConfirmPassword;
    },
  },
};
</script>

<style>
body {
  background-color: #e4e3e3;
}
</style>
