<template>
  <div class="flex overflow-hidden bg-white">
    <aside class="sidebar bg-gray-100 w-64">
      <div class="flex items-center gap-4 p-4 text-xs font-extrabold text-white bg-red-950 rounded-lg">
        <img src="../../../public/assets/Exclude.png" alt="Logo" class="object-contain w-[20px]" />
        <span>$IKEDEB</span>
      </div>
      <Link href="/dashboard" class="sidebar-link" :class="{'active': activeMenu === 'home'}" @click="setActiveMenu('home')">
        <img src="../../../public/assets/Vector.png" alt="Home Icon" class="icon" /> 
        Home
      </Link>
      <a href="/kelola" class="sidebar-link" :class="{'active': activeMenu === 'kelola'}" @click="setActiveMenu('kelola')">
        <img src="../../../public/assets/Icon.png" alt="Kelola Data Icon" class="icon" /> 
        Kelola Data
      </a>
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

      <nav class="tabs mt-4 flex space-x-4">
        <a href="#" @click="setTab('all')" :class="{'active-tab': currentTab === 'all'}">All</a>
        <a href="#" @click="setTab('ongoing')" :class="{'active-tab': currentTab === 'ongoing'}">On Going</a>
        <a href="#" @click="setTab('approved')" :class="{'active-tab': currentTab === 'approved'}">Approved</a>
        <a href="#" @click="setTab('rejected')" :class="{'active-tab': currentTab === 'rejected'}">Rejected</a>
      </nav>

      <table class="data-table mt-4">
        <thead>
          <tr>
            <th>NIK</th>
            <th>Nama</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="nasabah in nasabahList" :key="nasabah.id">
            <td>{{ nasabah.nik }}</td>
            <td>{{ nasabah.nama }}</td>
            <td>{{ nasabah.status }}</td>
            <td>
              <select @change="handleAction($event, nasabah.id)">
                <option value="">Pilih Aksi</option>
                <option value="hitung">Hitung</option>
                <option value="edit">Edit</option>
                <option value="hapus">Hapus</option>
              </select>
            </td>
          </tr>
        </tbody>
      </table>
    </main>
  </div>
</template>

<script setup>
import { ref, computed } from 'vue';
import { Inertia } from '@inertiajs/inertia';

const activeMenu = ref('home');
const searchQuery = ref('');
const currentTab = ref('all');

function setActiveMenu(menu) {
  activeMenu.value = menu;
}

function addNew() {
  Inertia.visit('/kelola');
}

function setTab(tab) {
  currentTab.value = tab;
}

function handleAction(event, id) {
  const action = event.target.value;
  if (action === 'hitung') {
    alert(`Menghitung data nasabah dengan ID: ${id}`);
  } else if (action === 'edit') {
    Inertia.get(route('data.edit', id));
  } else if (action === 'hapus') {
    if (confirm('Yakin ingin menghapus nasabah ini?')) {
      Inertia.delete(route('data.destroy', id), {
        onSuccess: () => {
          alert('Nasabah berhasil dihapus');
          event.target.value = ''; // reset dropdown
        },
        onError: () => alert('Terjadi kesalahan saat menghapus data'),
      });
    }
  }
  event.target.value = ''; // reset dropdown
}

</script>

<script>
export default {
  props: {
    nasabahList: Array,
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
  