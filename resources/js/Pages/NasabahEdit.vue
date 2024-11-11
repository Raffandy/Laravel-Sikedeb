<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64">
      <!-- Sidebar implementation remains unchanged -->
      ...
    </aside>

    <main class="flex-1 p-5">
      <header class="py-4">
        <div class="container mx-auto flex justify-between items-center px-9">
          <h1 class="text-gray-800 font-bold">{{ activeMenu === 'home' ? 'Home' : 'Kelola Data' }}</h1>
          <div class="flex items-center gap-2">
            <div class="relative">
              <input type="text" v-model="searchQuery" placeholder="Search..." class="search-input" />
              <button @click="handleSearch" class="search-button absolute inset-y-0 right-0 flex items-center pr-3">🔍</button>
            </div>
            <button @click="addNew" class="add-new-button">Add New</button>
          </div>
        </div>
      </header>

      <!-- Personal Details Form -->
      <form v-if="activeDataMenu === 'personal'" class="personal-details-form mt-4" @submit.prevent="nextForm('personal')">
        <h2 class="text-lg font-bold mb-2">Personal Details</h2>
        <div class="flex flex-col space-y-2">
          <input type="text" v-model="personalDetails.nama" placeholder="Nama" class="form-input" required />
          <input type="text" v-model="personalDetails.nik" placeholder="NIK" class="form-input" required />
          <input type="text" v-model="personalDetails.alamat" placeholder="Alamat" class="form-input" required />
          <input type="text" v-model="personalDetails.pekerjaan" placeholder="Pekerjaan" class="form-input" required />
          <input type="text" v-model="personalDetails.jenis_usaha" placeholder="Jenis Usaha" class="form-input" required />
        </div>
        <button type="submit" class="next-button mt-4">Next</button>
      </form>

      <!-- Applicant Details Form -->
      <form v-if="activeDataMenu === 'applicant'" class="applicant-details-form mt-4" @submit.prevent="nextForm('applicant')">
        <h2 class="text-lg font-bold mb-2">Applicant Details</h2>
        <div class="flex flex-col space-y-2">
          <label for="penilaianSLIK" class="font-semibold">Penilaian SLIK OJK</label>
          <select id="penilaianSLIK" v-model="applicantDetails.slik" class="form-input" required>
            <option value="" disabled selected>Pilih Penilaian (1-5)</option>
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
          </select>
          <input type="number" v-model="applicantDetails.pendapatan_utama" placeholder="Pendapatan Utama" class="form-input" required />
          <input type="number" v-model="applicantDetails.pendapatan_lain" placeholder="Pendapatan Lain" class="form-input" required />
          <input type="number" v-model="applicantDetails.modal" placeholder="Modal" class="form-input" required />
          <input type="number" v-model="applicantDetails.aset" placeholder="Aset Selain Jaminan" class="form-input" required />
          <input type="number" v-model="applicantDetails.tanggungan" placeholder="Jumlah Tanggungan" class="form-input" required />
          <input type="number" v-model="applicantDetails.biaya_lain" placeholder="Biaya Lain" class="form-input" required />
        </div>
        <button type="submit" class="next-button mt-4">Next</button>
      </form>

      <!-- Collateral Details Form -->
      <form v-if="activeDataMenu === 'collateral'" class="collateral-details-form mt-4" @submit.prevent="finishEdit">
        <h2 class="text-lg font-bold mb-2">Collateral Details</h2>
        <div class="flex flex-col space-y-2">
          <label for="jenisJaminan" class="font-semibold">Jenis Jaminan</label>
          <select id="jenisJaminan" v-model="collateralDetails.jenis_jaminan" class="form-input" required>
            <option value="" disabled selected>Pilih Jenis Jaminan</option>
            <option value="BPKB">BPKB</option>
            <option value="SHM">SHM</option>
          </select>
          <input type="number" v-model="collateralDetails.harga" placeholder="Harga" class="form-input" required />
        </div>
        <button type="submit" class="finish-button mt-4">Finish</button>
      </form>
    </main>
  </div>
</template>


<script setup>
import { ref, onMounted } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const activeMenu = ref('kelola');
const activeDataMenu = ref('personal');
const searchQuery = ref('');
const isKelolaMenuOpen = ref(false);
const nasabahId = ref(null); // ID Nasabah untuk edit
const editMode = ref(false);

const personalDetails = ref({
  nama: '',
  nik: '',
  alamat: '',
  pekerjaan: '',
  jenis_usaha: '',
});

const applicantDetails = ref({
  slik: '',
  pendapatan_utama: '',
  pendapatan_lain: '',
  modal: '',
  aset: '',
  tanggungan: '',
  biaya_lain: '',
});

const collateralDetails = ref({
  jenis_jaminan: '',
  harga: '',
});

// Mengambil data untuk edit
onMounted(() => {
  if (editMode.value) {
    Inertia.get(`/data/${nasabahId.value}/edit`, {
      onSuccess: (page) => {
        const data = page.props.nasabah;
        Object.assign(personalDetails.value, data.personalDetails);
        Object.assign(applicantDetails.value, data.applicantDetails);
        Object.assign(collateralDetails.value, data.collateralDetails);
      },
    });
  }
});

function nextForm(currentForm) {
  if (currentForm === 'personal') {
    // Validasi Personal Details
    if (Object.values(personalDetails.value).every(field => field)) {
      activeDataMenu.value = 'applicant';
    } else {
      alert('All fields in Personal Details are required.');
    }
  } else if (currentForm === 'applicant') {
    // Validasi Applicant Details
    if (Object.values(applicantDetails.value).every(field => field)) {
      activeDataMenu.value = 'collateral';
    } else {
      alert('All fields in Applicant Details are required.');
    }
  } else if (currentForm === 'collateral') {
    // Validasi Collateral Details dan kirim data ke server
    if (Object.values(collateralDetails.value).every(field => field)) {
      const data = {
        ...personalDetails.value,
        ...applicantDetails.value,
        ...collateralDetails.value,
      };
      Inertia.post('/data/store', data, {
        onSuccess: () => alert('Data berhasil disimpan!'),
      });
    } else {
      alert('All fields in Collateral Details are required.');
    }
  }
}

function finishEdit() {
  const data = {
    ...personalDetails.value,
    ...applicantDetails.value,
    ...collateralDetails.value,
  };

  if (editMode.value) {
    Inertia.put(`/data/${nasabahId.value}`, data, {
      onSuccess: () => alert('Data berhasil diperbarui!'),
    });
  } else {
    Inertia.post('/data/store', data, {
      onSuccess: () => alert('Data berhasil disimpan!'),
    });
  }
}

function setActiveMenu(menu) {
  activeMenu.value = menu;
}

function toggleKelolaMenu() {
  isKelolaMenuOpen.value = !isKelolaMenuOpen.value;
}

function setActiveDataMenu(menu) {
  activeDataMenu.value = menu;
}

function handleSearch() {
  console.log('Search Query:', searchQuery.value);
}

function addNew() {
  Inertia.visit('/kelola');
}
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
