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

            <main className="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                    <h2 className="text-sm font-semibold text-gray-500 uppercase">Total Produk</h2>
                    <p className="text-2xl font-bold">0</p>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                    <h2 className="text-sm font-semibold text-gray-500 uppercase">Penjualan Hari Ini</h2>
                    <p className="text-2xl font-bold text-gray-800">Rp 0</p>
                </div>
                <div className="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                    <h2 className="text-sm font-semibold text-gray-500 uppercase">Stok Menipis</h2>
                    <p className="text-2xl font-bold text-gray-800">0</p>
                </div>
            </main>
        </div>
    );
}