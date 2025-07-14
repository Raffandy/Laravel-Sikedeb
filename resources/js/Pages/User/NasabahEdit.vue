<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64 flex flex-col">
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      <a href="/dashboard/data" class="sidebar-link" :class="{ 'active': activeMenu === 'home' }" @click="setActiveMenu('home')">
        <img src="../../../../public/assets/Vector.png" alt="Kelola Data Icon" class="icon" />
        Home
      </a>
      <div>
        <a href="#" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="toggleKelolaMenu">
          <img src="../../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
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
        </div>
      </div>

      <!-- Flex Grow to Push Profile to Bottom -->
      <div class="flex-grow"></div>

      <!-- User Profile Section (at the bottom) -->
      <div class="user-profile mt-4 p-4 cursor-pointer" @click="toggleProfileModal">
        <div class="flex items-center gap-2 p-2 border-t-2 border-gray-200 hover:bg-gray-100 rounded-lg">
          <img src="../../../../public/assets/user.png" alt="Profile Icon" class="icon" />
          <span class="text-sm font-medium">{{ username }}</span>
        </div>
      </div>
    </aside>

    <main class="flex-1 p-5">
      <header class="py-4">
        <h1 class="text-gray-800 font-bold">Edit Data Nasabah</h1>
      </header>

      <!-- User Profile Modal -->
      <div v-if="profileModalOpen" class="profile-modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-80 shadow-lg">
          <h2 class="text-xl font-bold mb-4">User Profile</h2>
          <p v-if="role === 'user'" p class="text-sm text-gray-600 mb-4">ID Petugas: {{ user.id }}</p>
          <p class="text-sm text-gray-600 mb-4">Name: {{ username }}</p>
          <p class="text-sm text-gray-600 mb-4">Email: {{ user.email }}</p>
          <p class="text-sm text-gray-600 mb-4">Keterangan: {{ role }}</p>
          <button @click="Inertia.get(route('profile.edit'));" class="cancel-button mt-2 w-full bg-blue-300 text-black py-2 rounded">Profil</button>
          <button @click="Inertia.post(route('logout'));" class="logout-button mt-4 w-full bg-red-500 text-white py-2 rounded">Logout</button>
          <button @click="toggleProfileModal" class="cancel-button mt-2 w-full bg-gray-300 text-black py-2 rounded">Cancel</button>
        </div>
      </div>

      <!-- Form for Editing Nasabah Details -->
      <div :key="nasabah.id">
      <form @submit.prevent="updateNasabah">
        <!-- Personal Details Section -->
        <section v-if="activeDataMenu === 'personal'" class="personal-details-form mt-4">
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

        <!-- Applicant Details Section -->
        <section v-if="activeDataMenu === 'applicant'" class="applicant-details-form mt-4">
          <h2 class="text-lg font-bold mb-2">Applicant Details</h2>
          <div class="flex flex-col space-y-2">
            <label for="penilaianSLIK" class="font-semibold">Penilaian SLIK OJK</label>
            <select id="penilaianSLIK" v-model="form.slik" class="form-input" required>
              <option value="" disabled selected>Pilih Penilaian (1-5)</option>
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
            </select>
            <input type="number" v-model="form.pendapatan_utama" placeholder="Pendapatan Utama" class="form-input" required />
            <input type="number" v-model="form.pendapatan_lain" placeholder="Pendapatan Lain" class="form-input" />
            <input type="number" v-model="form.modal" placeholder="Modal" class="form-input" />
            <input type="number" v-model="form.aset" placeholder="Aset Selain Jaminan" class="form-input" />
            <input type="number" v-model="form.tanggungan" placeholder="Jumlah Tanggungan" class="form-input" />
            <input type="number" v-model="form.biaya_lain" placeholder="Biaya Lain" class="form-input" />
          </div>
          <button type="button" @click="nextForm('collateral')" class="next-button mt-4">Next</button>
        </section>

        <!-- Collateral Details Section -->
        <section v-if="activeDataMenu === 'collateral'" class="collateral-details-form mt-4">
          <h2 class="text-lg font-bold mb-2">Collateral Details</h2>
          <div class="flex flex-col space-y-2">
            <label for="jenisJaminan" class="font-semibold">Jenis Jaminan</label>
            <select id="jenis_Jaminan" v-model="form.jenis_jaminan" class="form-input" required>
              <option value="" disabled selected>Pilih Jenis Jaminan</option>
              <option value="BPKB">BPKB</option>
              <option value="SHM">SHM</option>
            </select>
            <input type="number" v-model="form.harga" placeholder="Harga" class="form-input" required />
          </div>
          <button type="submit" class="finish-button mt-4">Save</button>
        </section>
      </form>
      </div>
    </main>
  </div>
</template>

<script>
import { ref, reactive, watch } from 'vue';
import { Inertia } from '@inertiajs/inertia';

export default {
  props: {
    nasabah: Object,
    username: String,
    role: String,
    user: Array,
  },
  setup(props) {
    const activeDataMenu = ref('personal');
    const isKelolaMenuOpen = ref(true);
    const profileModalOpen = ref(false);
    

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
    };

    // Watch nasabah to update form fields when props.nasabah changes
    watch(() => props.nasabah, (newNasabah) => {
      updateFormFields(newNasabah);
    }, { immediate: true });

    const toggleKelolaMenu = () => {
      isKelolaMenuOpen.value = !isKelolaMenuOpen.value;
    };

    const setActiveDataMenu = (menu) => {
      activeDataMenu.value = menu;
    };

    const nextForm = (section) => {
      activeDataMenu.value = section;
    };

    const updateNasabah = () => {
      Inertia.put(`/data/${props.nasabah.id}`, form, {
        onSuccess: () => {
          alert('Data berhasil diperbarui!');
        },
        onError: (errors) => {
          console.log('Update error:', errors);
        }
      });
    };

    function toggleProfileModal() {
      profileModalOpen.value = !profileModalOpen.value;
    };

    const profile = () => {
      Inertia.get(route('profile.edit'));
    };

    const logout = () => {
      Inertia.post(route('logout'));
    };

    return {
      form,
      activeDataMenu,
      nextForm,
      updateNasabah,
      isKelolaMenuOpen,
      setActiveDataMenu,
      toggleKelolaMenu,
      profileModalOpen,
      toggleProfileModal,
      profile,
      logout,
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
