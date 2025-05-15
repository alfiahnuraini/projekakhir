const listProduk = JSON.parse(localStorage.getItem('produkList')) || [];

let mode= 'tambah'

//creat, read, update, delete
const tampilkanProduk = () => {
    const tabelProduk = document.getElementById('tabelProduk')
    tabelProduk.innerHTML = `<tr> <th>No</th> <th>Nama Produk</th> <th>Harga</th> <th>Stok</th> <th>Kategori</th> <th>Aksi</tr> </tr>`

    for(let index in listProduk) {
        console.log(`${parseInt(index)+1}. ${listProduk[index].namaProduk} ${listProduk[index].harga} ${listProduk[index].stok}  ${listProduk[index].kategori}`)

        tabelProduk.innerHTML += `<tr><td>${parseInt(index) + 1}.</td><td>${listProduk[index].namaProduk}</td><td>${listProduk[index].harga}</td><td>${listProduk[index].stok}</td><td>${listProduk[index].kategori}</td> <td><button class="btn btn-warning" onclick="editProduk('${listProduk[index].namaProduk}')">edit</button> 
        <button class="btn btn-danger" onclick="hapusProduk('${listProduk[index].namaProduk}')">Hapus</button></td></tr>`
    }
}

tampilkanProduk()


let tambahProduk = () => {
    const namaProduk = document.getElementById('txtnamaProduk').value
    const harga = document.getElementById('txtharga').value
    const stok = document.getElementById('txtstok').value
    const kategori = document.getElementById('txtkategori').value

    const produkBaru = {
        namaProduk : namaProduk,
        harga: harga,
        stok: stok,
        kategori : kategori,
    }

    //tambah
    if (mode == 'tambah'){
        listProduk.push(produkBaru)
    } else{
        listProduk[mode] = produkBaru
    }

    localStorage.setItem('produkList',JSON.stringify(listProduk));

    document.getElementById('txtnamaProduk').value =""
    document.getElementById('txtharga').value =""
    document.getElementById('txtstok').value =""
    document.getElementById('txtkategori').value =""
    

    mode = 'tambah'

    tampilkanProduk()

}

const cariProduk = (namaProduk) => {
    // tampilkan stok jika nama produk == nama
    for (let i = 0; i < listProduk.length; i++){
        if (listProduk[i].namaProduk == namaProduk) 
            return i
    }
    return -1
}

const hapusProduk = (target) => {
    const produkDiHapus = cariProduk(target)
    // menghapus elemen dari dalam array
    if (produkDiHapus !== -1) {
    listProduk.splice(produkDiHapus, 1)
    tampilkanProduk()
    }

    localStorage.setItem('produkList',JSON.stringify(listProduk));
    hapusProduk()
}

const editProduk = (target) => {
    const produkEdit = cariProduk(target);
    const produkDiedit = listProduk[produkEdit];

    const namaProduk = document.getElementById('txtnamaProduk').value = target
    const harga = document.getElementById('txtharga').value = produkDiedit.harga
    const stok = document.getElementById('txtstok').value = produkDiedit.stok
    const kategori = document.getElementById('txtkategori').value = produkDiedit.kategori


    mode = produkEdit

    console.log(target)
    console.log(produkEdit)
    console.log(listProduk[produkEdit])
}

const cancel = () => {
    const namaProduk = document.getElementById('txtnamaProduk').value =""
    const harga = document.getElementById('txtharga').value =""
    const stok = document.getElementById('txtstok').value =""
    const kategori = document.getElementById('txtkategori').value =""

    mode = 'tambah'
}