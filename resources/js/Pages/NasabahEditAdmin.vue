<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64 flex flex-col">
      <!-- Sidebar Content -->
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <span>$IKEDEB</span>
      </div>
      <a href="/dashboard/data" class="sidebar-link" :class="{'active': activeMenu === 'home'}" @click="setActiveMenu('home')">
        <img src="../../../public/assets/Vector.png" alt="Home Icon" class="icon" />
        Home
      </a>
      <div>
        <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="toggleKelolaMenu">
          Kelola Data
        </a>
        <div v-if="isKelolaMenuOpen" class="submenu">
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'personal'}" @click="setActiveDataMenu('personal')">
            Personal Details
          </a>
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'applicant'}" @click="setActiveDataMenu('applicant')">
            Applicant Details
          </a>
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'collateral'}" @click="setActiveDataMenu('collateral')">
            Collateral Details
          </a>
          <a href="#" class="sidebar-link" :class="{'active': activeDataMenu === 'operator'}" @click="setActiveDataMenu('operator')">
            Operator Details
          </a>
        </div>
      </div>
    </aside>

    <main class="flex-1 p-5">
      <header class="py-4">
        <h1 class="text-gray-800 font-bold">Edit Data Nasabah</h1>
      </header>

      <form @submit.prevent="updateNasabah">
        <!-- Personal Details -->
        <section v-if="activeDataMenu === 'personal'" class="mt-4">
          <h2 class="text-lg font-bold mb-2">Personal Details</h2>
          <div class="flex flex-col space-y-2">
            <input type="text" v-model="form.nama" placeholder="Nama" class="form-input" required />
            <input type="text" v-model="form.nik" placeholder="NIK" class="form-input" required />
            <input type="text" v-model="form.alamat" placeholder="Alamat" class="form-input" required />
            <input type="text" v-model="form.pekerjaan" placeholder="Pekerjaan" class="form-input" required />
            <input type="text" v-model="form.jenis_usaha" placeholder="Jenis Usaha" class="form-input" required />
          </div>
          <button type="button" @click="nextForm('applicant')" class="next-button mt-4">Next</button>
        </section>

        <!-- Applicant Details -->
        <section v-if="activeDataMenu === 'applicant'" class="mt-4">
          <h2 class="text-lg font-bold mb-2">Applicant Details</h2>
          <div class="flex flex-col space-y-2">
            <label for="slik">SLIK OJK</label>
            <select v-model="form.slik" id="slik" class="form-input" required>
              <option value="" disabled>Pilih Penilaian (1-5)</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <input type="number" v-model="form.pendapatan_utama" placeholder="Pendapatan Utama" class="form-input" required />
            <input type="number" v-model="form.pendapatan_lain" placeholder="Pendapatan Lain" class="form-input" />
            <input type="number" v-model="form.modal" placeholder="Modal" class="form-input" />
            <input type="number" v-model="form.aset" placeholder="Aset" class="form-input" />
            <input type="number" v-model="form.tanggungan" placeholder="Tanggungan" class="form-input" />
            <input type="number" v-model="form.biaya_lain" placeholder="Biaya Lain" class="form-input" />
          </div>
          <button type="button" @click="nextForm('collateral')" class="next-button mt-4">Next</button>
        </section>

        <!-- Collateral Details -->
        <section v-if="activeDataMenu === 'collateral'" class="mt-4">
          <h2 class="text-lg font-bold mb-2">Collateral Details</h2>
          <div class="flex flex-col space-y-2">
            <label for="jenis_jaminan">Jenis Jaminan</label>
            <select v-model="form.jenis_jaminan" id="jenis_jaminan" class="form-input" required>
              <option value="" disabled>Pilih Jenis Jaminan</option>
              <option value="BPKB">BPKB</option>
              <option value="SHM">SHM</option>
            </select>
            <input type="number" v-model="form.harga" placeholder="Harga" class="form-input" required />
          </div>
          <button type="button" @click="nextForm('operator')" class="next-button mt-4">Next</button>
        </section>

        <!-- Operator Details -->
        <section v-if="activeDataMenu === 'operator'" class="mt-4">
          <h2 class="text-lg font-bold mb-2">Operator Details</h2>
          <div class="flex flex-col space-y-2">
            <label for="operator">Nama Operator</label>
            <select v-model="form.user_id" id="operator" class="form-input">
              <option value="" disabled>Pilih Operator</option>
              <option v-for="user in users" :key="user.id" :value="user.id">{{ user.name }}</option>
            </select>
          </div>
          <button type="submit" class="finish-button mt-4">Save</button>
        </section>
      </form>
    </main>
  </div>
</template>

<script>
import { ref, reactive, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    nasabah: Object,
    users: Array,
  },
  setup(props) {
    const activeDataMenu = ref('personal');
    const isKelolaMenuOpen = ref(false);

    const form = reactive({
      nama: '',
      nik: '',
      alamat: '',
      pekerjaan: '',
      jenis_usaha: '',
      slik: '',
      pendapatan_utama: 0,
      pendapatan_lain: 0,
      modal: 0,
      aset: 0,
      tanggungan: 0,
      biaya_lain: 0,
      jenis_jaminan: '',
      harga: 0,
      user_id: '',
    });

    const updateFormFields = (nasabah) => {
      form.nama = nasabah.nama || '';
      form.nik = nasabah.nik || '';
      form.alamat = nasabah.alamat || '';
      form.pekerjaan = nasabah.pekerjaan || '';
      form.jenis_usaha = nasabah.jenis_usaha || '';
      form.slik = nasabah.pengajuan?.slik || '';
      form.pendapatan_utama = nasabah.pengajuan?.pendapatan_utama || 0;
      form.pendapatan_lain = nasabah.pengajuan?.pendapatan_lain || 0;
      form.modal = nasabah.pengajuan?.modal || 0;
      form.aset = nasabah.pengajuan?.aset || 0;
      form.tanggungan = nasabah.pengajuan?.tanggungan || 0;
      form.biaya_lain = nasabah.pengajuan?.biaya_lain || 0;
      form.jenis_jaminan = nasabah.pengajuan?.jenis_jaminan || '';
      form.harga = nasabah.pengajuan?.harga || 0;
      form.user_id = nasabah.user_id || '';
    };

    watch(() => props.nasabah, (newNasabah) => {
      updateFormFields(newNasabah);
    }, { immediate: true });
    
    const nextForm = (menu) => {
      activeDataMenu.value = menu;
    };

    const toggleKelolaMenu = () => {
      isKelolaMenuOpen.value = !isKelolaMenuOpen.value;
    };

    const setActiveDataMenu = (menu) => {
      activeDataMenu.value = menu;
    };

    const updateNasabah = () => {
      Inertia.put(`/data/${props.nasabah.id}`, form);
    };

    return {
      form,
      activeDataMenu,
      isKelolaMenuOpen,
      nextForm,
      toggleKelolaMenu,
      setActiveDataMenu,
      updateNasabah,
    };
  },
};
</script>






<style scoped>
/* Styling tetap sesuai instruksi */
.sidebar { padding: 1rem; height: 100vh; }
.sidebar-link { display: flex; align-items: center; padding: 1rem; color: #333; }
.sidebar-link.active { color: blue; }
.sidebar-link:hover { background-color: #f0f0f0; }
.icon { width: 20px; margin-right: 0.5rem; }
.submenu { padding-left: 1rem; }
.search-input { border: 1px solid #ddd; padding: 0.5rem; }
.search-button { background: none; border: none; cursor: pointer; }
.add-new-button { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; }
.form-input { border: 1px solid #ddd; padding: 0.5rem; width: 100%; }
.next-button, .finish-button { background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 5px; cursor: pointer; }
.text-gray-500 {
  color: #a0aec0; /* This is a gray color; adjust as needed */
}

</style>
