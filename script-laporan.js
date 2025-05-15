document.addEventListener("DOMContentLoaded", function () {
const laporanList = JSON.parse(localStorage.getItem('LaporanList')) || [];
const tabel = document.getElementById("tabelHarian").getElementsByTagName('tbody')[0];

laporanList.forEach((item, index) => {
    const row  = tabel.insertRow();
        row.innerHTML = `
        <td>${(index) + 1}</td>
        <td>${item.noMeja || "noMeja"}</td>
        <td>${item.namaProduk || "namaProduk"}</td>
        <td>${item.jmlh || "jmlh"}</td>
        <td>${item.subtotal?.toLocaleString("id-ID") || "subtotal"}</td>
        <td>${item.tanggal || "-"}</td>
        `;
        
    });
});


const cariLaporan = (dataBaru) => {
    for (let i = 0; i < ListLaporan.length; i++){
        if (ListLaporan[i].dataBaru == dataBaru) 
            return i
    }
    return -1
}

const hapusLaporan = (target) => {
    const laporanDiHapus = cariLaporan(target)
    if (laporanDiHapus !== -ListLaporan.length) {
    ListLaporan.splice(laporanDiHapus, ListLaporan.length)
    tampilData()
    }
    localStorage.setItem('LaporanList',JSON.stringify(ListLaporan));

    hapusLaporan()
}