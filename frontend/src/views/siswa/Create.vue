<template>
  <div class="container mt-5">
    <div class="row">
      <div class="col-md-12">
        <div class="card border-0 rounded shadow">
          <div class="card-body">
            <h4>TAMBAH SISWA</h4>
            <hr>
            <form @submit.prevent="store">
              <div class="form-group">
                <label for="title" class="font-weight-bold">Nama Siswa</label>
                <input type="text" class="form-control" v model="post.nama" placeholder="Masukkan nama siswa">
                <!-- validation -->
                <div v-if="validation.nama" class="mt-2 alert alert danger">
                  {{ validation.nama[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight-bold">Alamat</label>
                <input type="text" class="form-control" v model="post.alamat" placeholder="Nama jalan dan nomor rumah">
                <!-- validation -->
                <div v-if="validation.alamat" class="mt-2 alert alert danger">
                  {{ validation.alamat[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight-bold">Kota</label> <input type="text" class="form-control" v
                  model="post.kota" placeholder="Masukkan nama kota tempat tinggal">
                <!-- validation -->
                <div v-if="validation.kota" class="mt-2 alert alert danger">
                  {{ validation.kota[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight bold">Provinsi</label>
                <input type="text" class="form-control" v model="post.provinsi"
                  placeholder="Masukkan nama provinsi tempat tinggal"> <!-- validation -->
                <div v-if="validation.provinsi" class="mt-2 alert alert danger">
                  {{ validation.provinsi[0] }}
                </div>
              </div>
              <div class="form-group">
                <label for="title" class="font-weight-bold">E-mail</label> <input type="text" class="form-control" v
                  model="post.email" placeholder="Masukkan alamat email siswa">
                <!-- validation -->
                <div v-if="validation.email" class="mt-2 alert alert danger">
                  {{ validation.email[0] }}
                </div>
              </div>
              <button type="submit" class="btn btn-primary mt-3">SIMPAN</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template> 
<script>
import { reactive, ref } from 'vue'
import { useRouter } from 'vue-router'
import axios from 'axios'
export default {
  setup() {
    //initial state siswa 
    const post = reactive({
      nama: '',
      alamat: '',
      kota: '',
      provinsi: '',
      email: ''
    })
    //state validation
    const validation = ref([])
    //vue router 
    const router = useRouter()
    //method store 
    function store() {
      let nama = post.nama
      let alamat = post.alamat
      let kota = post.kota
      let provinsi = post.provinsi
      let email = post.email
      axios.post('http://localhost:8000/api/siswa', {
        nama: nama,
        alamat: alamat,
        kota: kota,
        provinsi: provinsi,
        email: email
      }).then(() => {
        //redirect ke siswa index 
        router.push({
          name: 'siswa.index'
        })
      }).catch(error => {
        //assign state validation with error
        validation.value = error.response.data
      })
    }
    //return 
    return {
      post,
      validation,
      router,
      store,

    }
  }
}
</script> 
<style> body {
   background: #e4e3e3;
 }</style>
 