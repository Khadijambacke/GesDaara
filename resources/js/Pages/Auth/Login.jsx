import Checkbox from '@/Components/Checkbox';
import InputError from '@/Components/InputError';
import InputLabel from '@/Components/InputLabel';
import PrimaryButton from '@/Components/PrimaryButton';
import TextInput from '@/Components/TextInput';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Login({ status, canResetPassword }) {
    const { data, setData, post, processing, errors, reset } = useForm({
        email: '',
        password: '',
        remember: false,
    });

    const submit = (e) => {
        e.preventDefault();

        post(route('login'), {
            onFinish: () => reset('password'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Connexion" />

            <div className="mb-6 text-center">
                <h2 className="text-2xl font-black text-cedar-950">Bon retour !</h2>
                <p className="text-sm font-medium text-cedar-500 mt-2">Connectez-vous à votre espace SunuDaara.</p>
            </div>

            {status && (
                <div className="mb-4 text-sm font-medium text-green-600">
                    {status}
                </div>
            )}

            <form onSubmit={submit} className="space-y-6">
                {/* Email Address */}
                <div>
                    <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Adresse Email</label>
                    <input
                        id="email"
                        type="email"
                        name="email"
                        value={data.email}
                        className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                        autoComplete="username"
                        required
                        autoFocus
                        onChange={(e) => setData('email', e.target.value)}
                    />
                    <InputError message={errors.email} className="mt-2 text-red-500 text-xs" />
                </div>

                {/* Password */}
                <div>
                    <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-2">Mot de passe</label>
                    <input
                        id="password"
                        type="password"
                        name="password"
                        value={data.password}
                        className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-3 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                        autoComplete="current-password"
                        required
                        onChange={(e) => setData('password', e.target.value)}
                    />
                    <InputError message={errors.password} className="mt-2 text-red-500 text-xs" />
                </div>

                {/* Remember Me & Forgot Password */}
                <div className="flex items-center justify-between">
                    <label className="inline-flex items-center cursor-pointer">
                        <input
                            id="remember_me"
                            type="checkbox"
                            name="remember"
                            checked={data.remember}
                            className="rounded border-cedar-300 text-cedar-900 shadow-sm focus:ring-cedar-900"
                            onChange={(e) =>
                                setData('remember', e.target.checked)
                            }
                        />
                        <span className="ml-2 text-xs font-bold text-cedar-600">
                            Se souvenir de moi
                        </span>
                    </label>

                    {canResetPassword && (
                        <Link
                            href={route('password.request')}
                            className="text-xs font-bold text-cedar-600 hover:text-cedar-950 transition-colors"
                        >
                            Mot de passe oublié ?
                        </Link>
                    )}
                </div>

                <div className="pt-2">
                    <button type="submit" disabled={processing} className="w-full px-6 py-4 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all">
                        Se connecter
                    </button>
                </div>

                <div className="text-center mt-6">
                    <p className="text-xs font-bold text-cedar-600">
                        Pas encore de compte ?{' '}
                        <Link
                            href={route('register')}
                            className="text-cedar-900 hover:text-cedar-950 underline decoration-2 underline-offset-4"
                        >
                            S'inscrire
                        </Link>
                    </p>
                </div>
            </form>
        </GuestLayout>
    );
}
