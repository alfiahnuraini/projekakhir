document.addEventListener('alpine:init', () => {
    Alpine.data('produk', () => ({
        item : [
            { id: 1, name:'Mie Kangen', img: 'contoh.jpg', price: 10000 },
            { id: 2, name:'Mie Happy', img: 'contoh.jpg', price: 10000 },
            { id: 3, name:'Mie Angel', img: 'contoh.jpg', price: 10000 },
            { id: 4, name:'Mie Jebew', img: 'contoh.jpg', price: 10000 },
            { id: 5, name:'Dimsum Ayam', img: 'contoh.jpg', price: 6000 },
            { id: 6, name:'Udang Keju', img: 'contoh.jpg', price: 6000 },
            { id: 7, name:'Udang Rambutan', img: 'contoh.jpg', price: 6000 },
            { id: 8, name:'Pangsit', img: 'contoh.jpg', price: 6000 },
            { id: 9, name:'Sosis', img: 'contoh.jpg', price: 5000 },
            { id: 5, name:'Nuget', img: 'contoh.jpg', price: 5000 },
            { id: 11, name:'Cireng', img: 'contoh.jpg', price: 5000 },
            { id: 12, name:'Teh', img: 'contoh.jpg', price: 3000 },
            { id: 13, name:'Es Nutrisari', img: 'contoh.jpg', price: 3000 },
            { id: 14, name:'Es Taro', img: 'contoh.jpg', price: 6000 },
            { id: 15, name:'Es Redvelvet', img: 'contoh.jpg', price: 6000 },
            { id: 16, name:'Es Grentea Matcha', img: 'contoh.jpg', price: 6000 },
            { id: 17, name:'Es Coklat', img: 'contoh.jpg', price: 6000 },
            { id: 18, name:'Es Cappucino', img: 'contoh.jpg', price: 6000 },
        ],
    }));
});
