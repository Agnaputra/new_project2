import React from 'react';

export default function App() {
    return (
        <div className="min-h-screen bg-gray-100 p-6">
            <header className="mb-8">
                <h1 className="text-3xl font-bold text-blue-600">
                    Sistem Stok & Penjualan
                </h1>
                <p className="mt-2 text-gray-600">
                    React + Laravel + Tailwind siap 🚀
                </p>
            </header>

            <main>
                <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {/* Card Total Produk */}
                    <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                        <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide">Total Produk</h2>
                        <p className="text-2xl font-bold text-gray-800">0</p>
                    </div>

                    {/* Card Penjualan */}
                    <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                        <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide">Penjualan Hari Ini</h2>
                        <p className="text-2xl font-bold text-gray-800">Rp 0</p>
                    </div>

                    {/* Card Stok Menipis */}
                    <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                        <h2 className="text-sm font-semibold text-gray-500 uppercase tracking-wide">Stok Menipis</h2>
                        <p className="text-2xl font-bold text-gray-800">0</p>
                    </div>
                </div>

                <div className="mt-8 bg-white p-6 rounded-lg shadow-md">
                    <h2 className="text-xl font-semibold mb-4 text-gray-800">Daftar Produk Terbaru</h2>
                    <div className="text-center py-10 text-gray-500 italic border-2 border-dashed border-gray-200 rounded-lg">
                        Belum ada data produk tersedia.
                    </div>
                </div>
            </main>
        </div>
    );
}