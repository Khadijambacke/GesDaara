import { Link } from '@inertiajs/react';

export default function GuestLayout({ children }) {
    return (
        <div className="min-h-screen w-screen flex flex-col items-center justify-center py-6 sm:py-10 p-4 bg-cedar-50/50 overflow-y-auto">
            <div className="mb-4 flex flex-col items-center">
                <Link href="/" className="flex flex-col items-center gap-2">
                    <div className="w-12 h-12 bg-cedar-900 text-white rounded-xl flex items-center justify-center shadow-md shadow-cedar-900/20">
                        <svg xmlns="http://www.w3.org/2000/svg" className="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h1 className="text-2xl font-black text-cedar-950 tracking-tight">SunuDaara</h1>
                </Link>
            </div>

            <div className="w-full px-6 sm:px-8 py-6 sm:py-8 bg-white shadow-2xl shadow-cedar-950/5 border border-cedar-100 rounded-[2rem] sm:rounded-[2.5rem] sm:max-w-md overflow-hidden">
                {children}
            </div>
        </div>
    );
}
