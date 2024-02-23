<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <div class="logout-button">
              <button @click="logoutUser" class="btn btn-danger">Logout</button>
            </div>
            <div>
              <h4>DATA SISWA</h4>
            </div>
            <hr />
            <router-link :to="{ name: 'siswa.create' }" class="btn btn-md btn-success" v-if="isAdmin">TAMBAH
              SISWA</router-link>
            <table class="table table-striped table-bordered mt-4">
              <thead class="thead-dark">
                <tr>
                  <th scope="col">No</th>
                  <th scope="col">Nama</th>
                  <th scope="col">Alamat</th>
                  <th scope="col">Kota</th>
                  <th scope="col">Provinsi</th>
                  <th scope="col">E-mail</th>
                  <th scope="col" style="width: 120px;" v-if="isAdmin">Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr v-for="(siswa, index) in paginatedPosts()" :key="index">
                  <td>{{ (currentPage * 15) - (15 - (index + 1)) }}</td>
                  <td>{{ siswa.nama }}</td>
                  <td>{{ siswa.alamat }}</td>
                  <td>{{ siswa.kota }}</td>
                  <td>{{ siswa.provinsi }}</td>
                  <td>{{ siswa.email }}</td>
                  <td class="text-center" v-if="isAdmin">
                    <router-link :to="{ name: 'siswa.edit', params: { id: siswa.id } }"
                      class="btn btn-sm btn-primary mr-1">Edit</router-link>
                    <button @click="postDelete(siswa.id)" class="btn btn-sm btn-danger ml-1">Delete</button>
                  </td>
                </tr>
              </tbody>
            </table>
            <nav aria-label="Page navigation mt-4">
              <ul class="pagination justify-content-center">
                <li class="page-item" :class="{ 'disabled': currentPage === 1 }">
                  <button class="page-link" @click="changePage(currentPage - 1)">Previous</button>
                </li>
                <li class="page-item" v-for="page in totalPages" :key="page" :class="{ 'active': currentPage === page }">
                  <button class="page-link" @click="changePage(page)">{{ page }}</button>
                </li>
                <li class="page-item" :class="{ 'disabled': currentPage === totalPages }">
                  <button class="page-link" @click="changePage(currentPage + 1)">Next</button>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>
<script>
import axios from "axios";
import { onMounted, ref, computed } from "vue";
import { useRouter } from "vue-router";  // Import the useRouter function

export default {
  setup() {
    const router = useRouter();  // Use the useRouter function to obtain the router instance

    // reactive state
    let posts = ref([]);
    let currentPage = ref(1);
    let pageSize = ref(15);
    let isAdmin = ref(false);

    // mounted
    onMounted(() => {
      isAdmin.value = localStorage.getItem("role") === "admin";
      // get API from Laravel Backend
      axios
        .get("http://localhost:8000/api/siswa")
        .then((response) => {
          console.log(response.data);
          // assign state posts with response data
          posts.value = response.data.data;
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    });

    const totalPages = computed(() => Math.ceil(posts.value.length / pageSize.value));

    // method delete
    function postDelete(id) {
      // delete data post by ID
      axios
        .delete(`http://localhost:8000/api/siswa/${id}`)
        .then(() => {
          // splice posts
          const index = posts.value.findIndex((post) => post.id === id);
          if (~index) {
            posts.value.splice(index, 1);
          }
        })
        .catch((error) => {
          console.log(error.response.data);
        });
    }

    function changePage(page) {
      if (page >= 1 && page <= totalPages.value) {
        currentPage.value = page;
      }
    }

    function paginatedPosts() {
      const start = (currentPage.value - 1) * pageSize.value;
      const end = start + pageSize.value;
      return posts.value.slice(start, end);
    }

    function logoutUser() {
      axios
        .post(
          "http://localhost:8000/api/logout",
          null,
          {
            headers: {
              Authorization: `Bearer ${localStorage.getItem("token")}`,
            },
          },
          {
            withCredentials: true,
          }
        )
        .then(response => {
          if (response && response.data) {
            // Handle successful logout response
            console.log(response.data);
            localStorage.removeItem('token');
            router.push({ name: 'login' });
          } else {
            console.error('Invalid response format');
          }
        })
        .catch(error => {
          if (error.response && error.response.data) {
            console.error(error.response.data);
          } else {
            console.error('Unexpected error:', error);
          }
        });
    }

    // return
    return {
      posts: paginatedPosts,
      currentPage,
      totalPages,
      changePage,
      postDelete,
      paginatedPosts,
      logoutUser,
      isAdmin
    };
  },
};
</script>

<style>
body {
  background: #e4e3e3;
}

.logout-button {
  position: absolute;
  top: 10px;
  right: 10px;
}
</style>
