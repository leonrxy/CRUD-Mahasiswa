<template>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card border-0 rounded-3 shadow">
          <div class="card-body">
            <h2 class="text-center">Login</h2>
            <form @submit.prevent="loginUser" class="form-horizontal padding-md">
              <div class="form-group mt-3">
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

              <div class="form-group mt-3">
                <div class="d-grid gap-2">
                  <button type="submit" class="btn btn-primary" :disabled="loading">
                    <span v-if="loading" class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
                    <span v-else>Login</span>
                  </button>
                </div>
              </div>

              <div v-if="errorMessage" class="alert alert-danger mt-3" role="alert">
                {{ errorMessage }}
              </div>
            </form>

            <p class="mt-3 text-center">
              Belum punya akun?
              <router-link to="/register">Register</router-link>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      loading: false,
      errorMessage: '',
      showPassword: false,
    };
  },
  methods: {
    loginUser() {
      this.loading = true;
      axios
        .post('http://localhost:8000/api/login', {
          email: this.email,
          password: this.password,
        })
        .then((response) => {
          console.log(response.data);
          localStorage.setItem('token', response.data.token);
          localStorage.setItem('role', response.data.user.role);
          this.$router.push({ name: 'siswa.index' });
        })
        .catch((error) => {
          console.error(error.response.data);
          this.errorMessage = error.response.data.error || 'An error occurred';
        })
        .finally(() => {
          this.loading = false;
        });
    },
    togglePasswordVisibility() {
      this.showPassword = !this.showPassword;
    },
  },
};
</script>
<style>
body {
  background-color: #e4e3e3;
}
</style>

