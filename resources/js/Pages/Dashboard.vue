<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64 flex flex-col">
      <!-- Logo Section -->
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      
      <!-- Sidebar Links -->
      <Link href="/dashboard" class="sidebar-link" :class="{'active': activeMenu === 'home'}" @click="setActiveMenu('home')">
        <img src="../../../public/assets/Vector.png" alt="Home Icon" class="icon" /> 
        Home
      </Link>
          <!-- Sesuaikan Bar kelola untuk User dan Admin -->
      <a v-if="role === 'user'" href="/kelola" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="setActiveMenu('kelola')">
        <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
        Kelola Data
      </a>
      <a v-if="role === 'admin'" href="/kelola-admin" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="setActiveMenu('kelola')">
        <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
        Kelola Data
      </a>
          <!-- End of Sesuaikan Bar Kelola untuk User dan Admin -->
      <a v-if="role === 'admin'" href="/profil-standar" class="sidebar-link" :class="{'active': activeMenu === 'profil standar'}" @click="setActiveMenu('profil standar')">
        <img src="../../../public/assets/IconPenilaian.png" alt="Penilaian Icon" class="icon" /> 
        Profil Standar
      </a>
      <a v-if="role === 'admin'" href="/register" class="sidebar-link" :class="{'active': activeMenu === 'register'}" @click="setActiveMenu('register')">
        <img src="../../../public/assets/Register.png" alt="Register Icon" class="icon" /> 
        Registrasi User
      </a>
      

      <!-- Flex Grow to Push Profile to Bottom -->
      <div class="flex-grow"></div>

      <!-- User Profile Section (at the bottom) -->
      <div class="user-profile mt-4 p-4 cursor-pointer" @click="toggleProfileModal">
        <div class="flex items-center gap-2 p-2 border-t-2 border-gray-200 hover:bg-gray-100 rounded-lg">
          <img src="../../../public/assets/user.png" alt="Profile Icon" class="icon" />
          <span class="text-sm font-medium">{{ username }}</span>
        </div>
      </div>
    </aside>

    <main class="flex-1 p-5">
      <header class="py-4">
        <div class="container mx-auto flex justify-between items-center px-9">
          <h1 class="text-gray-800 font-bold">{{ activeMenu === 'home' ? 'Home' : 'Kelola Data' }}</h1>
          <div class="flex items-center gap-2">
            <div class="relative">
              <input type="text" v-model="searchQuery" placeholder="Search..." class="search-input"  @keyup.enter="handleSearch"/>
              <button @click="handleSearch" class="search-button absolute inset-y-0 right-0 flex items-center pr-3">🔍</button>
            </div>
            <button v-if="role === 'admin'" @click="Inertia.visit('/kelola-admin');" class="add-new-button">Add New</button>
            <button v-if="role === 'user'" @click="Inertia.visit('/kelola');" class="add-new-button">Add New</button>
          </div>
        </div>
      </header>

      <!-- User Profile Modal -->
      <div v-if="profileModalOpen" class="profile-modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
        <div class="bg-white p-6 rounded-lg w-80 shadow-lg">
          <h2 class="text-xl font-bold mb-4">User Profile</h2>
          <p v-if="role === 'user'" p class="text-sm text-gray-600 mb-4">ID Petugas: {{ user.id }}</p>
          <p class="text-sm text-gray-600 mb-4">Name: {{ username }}</p>
          <p class="text-sm text-gray-600 mb-4">Email: {{ email }}</p>
          <p class="text-sm text-gray-600 mb-4">Keterangan: {{ role }}</p>
          <button @click="Inertia.get(route('profile.edit'));" class="cancel-button mt-2 w-full bg-blue-300 text-black py-2 rounded">Profil</button>
          <button @click="Inertia.post(route('logout'));" class="logout-button mt-4 w-full bg-red-500 text-white py-2 rounded">Logout</button>
          <button @click="toggleProfileModal" class="cancel-button mt-2 w-full bg-gray-300 text-black py-2 rounded">Cancel</button>
        </div>
      </div>

      <!-- Tabs Navigation -->
      <nav class="tabs mt-4 flex space-x-4">
        <a href="#" @click="setTab('all')" :class="{'active-tab': currentTab === 'all'}">All</a>
        <a href="#" @click="setTab('on going')" :class="{'active-tab': currentTab === 'on going'}">On Going</a>
        <a href="#" @click="setTab('layak')" :class="{'active-tab': currentTab === 'layak'}">Layak</a>
        <a href="#" @click="setTab('tidak layak')" :class="{'active-tab': currentTab === 'tidak layak'}">Tidak Layak</a>
      </nav>

      <!-- Table of Data Nasabah -->
      <table class="data-table mt-4">
        <thead>
          <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Status</th>
            <th v-if="role === 'admin'">ID Petugas</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="nasabah in nasabahList" :key="nasabah.id">
        <td class="px-4 py-2">{{ nasabah.nik }}</td>
        <td class="px-4 py-2">{{ nasabah.nama }}</td>
        <td class="px-4 py-2">{{ nasabah.status }}</td>
        <td v-if="role === 'admin'" class="px-4 py-2">{{ nasabah.user_id }}</td>
        <td class="px-4 py-2">
          <!-- Kontainer flex untuk tombol yang di tengah -->
          <div class="flex justify-center space-x-2">
            <!-- Tombol Hitung -->
            <button 
              @click="handleAction('hitung', nasabah)" 
              class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 focus:outline-none transition-all duration-300"
            >
              Hitung
            </button>
            
            <!-- Tombol Detail -->
            <button 
              @click="handleAction('detail', nasabah)" 
              class="bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 focus:outline-none transition-all duration-300"
            >
              Detail
            </button>
            
            <!-- Tombol Edit -->
            <button 
              @click="handleAction('edit', nasabah)" 
              class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-yellow-600 focus:outline-none transition-all duration-300"
            >
              Edit
            </button>
            
            <!-- Tombol Hapus -->
            <button 
              @click="handleAction('hapus', nasabah)" 
              class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 focus:outline-none transition-all duration-300"
            >
              Hapus
            </button>
          </div>
        </td>
      </tr>
        </tbody>
      </table>
    </main>
    <div v-if="assessmentModalOpen" class="assessment-modal fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center">
  <div class="bg-white p-4 rounded-lg max-w-md w-full shadow-2xl transform transition-all scale-100">
    <h2 class="text-base font-semibold mb-4 text-center text-gray-800">Assessment</h2>
    <div class="overflow-auto max-h-[300px] text-sm space-y-3">
      <!-- Horizontal Layout for Data -->
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">NIK</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.nik }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Nama Nasabah</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.nama }}</p>
      </div>
      <!-- Vertical Layout for Additional Data -->
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Penilaian SLIK OJK</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.slik }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Pendapatan Utama</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.pendapatan_utama }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Pendapatan Lain</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.pendapatan_lain }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Modal</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.modal }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Aset Selain Jaminan</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.aset }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Jumlah Tanggungan</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.tanggungan }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Biaya Lain</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.biaya_lain }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Jenis Jaminan</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.jenis_jaminan }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Harga</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.pengajuan.harga }}</p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Nilai Standar Kelayakan</p>
        <p class="text-gray-600 col-span-2">: {{nilaiMinimum}} </p>
      </div>
      <div class="grid grid-cols-3 gap-2 items-start">
        <p class="font-medium text-gray-800 col-span-1">Nilai yang Diperoleh</p>
        <p class="text-gray-600 col-span-2">: {{ selectedNasabah.nilai }}</p>
      </div>
      <div class="mt-3">
        <p class="text-gray-700 leading-relaxed">
          Maka ditanyakan: <strong>{{ selectedNasabah.status }}</strong>, berdasarkan nilai yang diperoleh dibandingkan dengan nilai standar kelayakan.
        </p>
      </div>
    </div>


    <!-- Actions -->
    <div class="flex justify-end mt-5 space-x-3">
      <button @click="assessmentModalOpen = false" class="bg-gray-100 text-gray-700 py-1 px-4 text-xs rounded-lg hover:bg-gray-200">
        Oke
      </button>
    </div>
  </div>
</div>
  </div>
</template>


<script setup>
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const activeMenu = ref('home');
const searchQuery = ref('');
const currentTab = ref('all');
const profileModalOpen = ref(false);
const assessmentModalOpen = ref(false);
const selectedNasabah = ref(null);

function setActiveMenu(menu) {
  activeMenu.value = menu;
}

function addNew() {
  Inertia.visit('/kelola');
}

function setTab(tab) {
  currentTab.value = tab;
  Inertia.get(route('data.get'), {
    search: searchQuery.value,
    filter: tab, // Kirim nilai filter
  });
}

function handleSearch() {
  Inertia.get(route('data.get'), {
    search: searchQuery.value,
    filter: currentTab.value, // Misalnya 'all', 'approved', dll.
  });
}

function handleAction(action, nasabah) {
  if (action === 'hitung') {
    Inertia.post(route('nasabah.hitung', nasabah.id), {}, {
      onSuccess: (page) => {
        // Pastikan data nasabah sudah diupdate setelah perhitungan
        selectedNasabah.value = page.props.nasabahList.find(n => n.id === nasabah.id);
        assessmentModalOpen.value = true;
      },
      onError: (errors) => {
        console.error('Gagal menghitung:', errors);
        alert('Gagal menghitung data nasabah');
      }
    });
  } else if (action === 'detail') {
    selectedNasabah.value = nasabah;
    assessmentModalOpen.value = true;
  } else if (action === 'edit') {
    Inertia.get(route('data.edit', nasabah.id));
  } else if (action === 'hapus') {
    if (confirm('Yakin ingin menghapus nasabah ini?')) {
      Inertia.delete(route('data.destroy', nasabah.id), {
        onSuccess: () => {
          alert('Nasabah berhasil dihapus');
        },
        onError: () => alert('Terjadi kesalahan saat menghapus data'),
      });
    }
  }
}


function toggleProfileModal() {
  profileModalOpen.value = !profileModalOpen.value;
}
</script>

<script>
export default {
  props: {
    nasabahList: Array,
    username: String,
    role: String,
    email: String,
    nilaiMinimum: Number,
    user: Array,
  },
};
</script>


  <style scoped>
  .sidebar {
    padding: 1rem;
    height: 100vh; /* Full height for the sidebar */
  }
  .sidebar-link {
    display: flex; /* Use flex to align items */
    align-items: center; /* Center items vertically */
    padding: 1rem;
    text-decoration: none;
    color: #333;
    transition: color 0.3s; /* Smooth transition for color */
  }
  .sidebar-link.active {
    color: blue; /* Change color to blue when active */
  }
  .sidebar-link:hover {
    background-color: #f0f0f0; /* Background color on hover */
  }
  
  .icon {
    width: 20px; /* Set icon size */
    margin-right: 0.5rem; /* Add space between icon and text */
  }
  
  .search-input {
    border: 1px solid #ddd;
    padding: 0.5rem;
    padding-right: 2.5rem; /* Add space for the search button */
  }
  
  .search-button {
    background-color: transparent; /* Make button transparent */
    border: none; /* Remove border */
    cursor: pointer; /* Change cursor to pointer */
  }
  
  .add-new-button {
    background-color: #3b82f6;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 5px;
  }
  
  .active-tab {
    font-weight: bold;
    color: #230202;
  }
  
  .tabs {
    margin-top: 1rem;
  }
  
  .tabs a {
    padding: 0.5rem 1rem; /* Add padding to each tab */
    border-radius: 5px; /* Round the corners */
    text-decoration: none;
    color: #333;
    transition: background-color 0.3s; /* Smooth transition for background */
  }
  .tabs a:hover {
    background-color: red; /* Change background on hover */
    color: white; /* Change text color on hover */
  }
  
  .data-table {
    width: 100%;
    border-collapse: collapse;
  }
  .data-table th,
  .data-table td {
    border: 1px solid #ddd;
    padding: 0.5rem;
  }
  
  .dropdown-button { 
    border: none;
    background: none;
    cursor: pointer;
    font-size: 1.5rem; /* Increase size for better visibility */
    line-height: 1; /* Mengatur jarak vertikal antara titik */
  }
  </style>