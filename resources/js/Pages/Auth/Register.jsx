import React, { useState } from 'react';
import InputError from '@/Components/InputError';
import GuestLayout from '@/Layouts/GuestLayout';
import { Head, Link, useForm } from '@inertiajs/react';

export default function Register() {
    const [step, setStep] = useState(1);
    const { data, setData, post, processing, errors, reset } = useForm({
        prenom: '',
        nom: '',
        email: '',
        telephone: '',
        adresse: '',
        password: '',
        password_confirmation: '',
        communaute_nom: '',
        communaute_description: '',
    });

    const nextStep = () => {
        // Valider uniquement les champs de l'étape 1 via la validation native du navigateur
        const form = document.querySelector('form');
        if (form) {
            const step1Inputs = form.querySelectorAll('input:not(#communaute_nom)');
            let isValid = true;
            step1Inputs.forEach(input => {
                if (!input.checkValidity()) {
                    isValid = false;
                    input.reportValidity();
                }
            });
            if (!isValid) return;
        }
        setStep(2);
    };

    const prevStep = () => {
        setStep(1);
    };

    const submit = (e) => {
        e.preventDefault();

        post(route('register'), {
            onFinish: () => reset('password', 'password_confirmation'),
        });
    };

    return (
        <GuestLayout>
            <Head title="Inscription" />

            <div className="mb-6 text-center">
                <h2 className="text-2xl font-black text-cedar-950">Créer un compte</h2>
                <p className="text-sm font-semibold text-cedar-500 mt-2">
                    {step === 1 
                        ? "Étape 1 : Informations Personnelles" 
                        : "Étape 2 : Votre Communauté"
                    }
                </p>
                {/* Indicateur d'étape minimaliste */}
                <div className="flex justify-center items-center gap-1.5 mt-3">
                    <div className={`h-1.5 rounded-full transition-all duration-300 ${step === 1 ? 'w-6 bg-cedar-900' : 'w-1.5 bg-cedar-200'}`}></div>
                    <div className={`h-1.5 rounded-full transition-all duration-300 ${step === 2 ? 'w-6 bg-cedar-900' : 'w-1.5 bg-cedar-200'}`}></div>
                </div>
            </div>

            <form onSubmit={submit} className="space-y-4">
                {step === 1 && (
                    <div className="space-y-4 animate-fadeIn">
                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Prénom</label>
                                <input
                                    id="prenom"
                                    name="prenom"
                                    value={data.prenom}
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('prenom', e.target.value)}
                                    required
                                    autoFocus
                                />
                                <InputError message={errors.prenom} className="mt-1 text-red-500 text-xs" />
                            </div>

                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Nom</label>
                                <input
                                    id="nom"
                                    name="nom"
                                    value={data.nom}
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('nom', e.target.value)}
                                    required
                                />
                                <InputError message={errors.nom} className="mt-1 text-red-500 text-xs" />
                            </div>
                        </div>

                        <div>
                            <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Adresse Email</label>
                            <input
                                id="email"
                                type="email"
                                name="email"
                                value={data.email}
                                className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                onChange={(e) => setData('email', e.target.value)}
                                required
                            />
                            <InputError message={errors.email} className="mt-1 text-red-500 text-xs" />
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Téléphone</label>
                                <input
                                    id="telephone"
                                    type="text"
                                    name="telephone"
                                    value={data.telephone}
                                    placeholder="Ex: 771234567"
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('telephone', e.target.value)}
                                    required
                                />
                                <InputError message={errors.telephone} className="mt-1 text-red-500 text-xs" />
                            </div>

                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Adresse</label>
                                <input
                                    id="adresse"
                                    type="text"
                                    name="adresse"
                                    value={data.adresse}
                                    placeholder="Ex: Dakar"
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('adresse', e.target.value)}
                                    required
                                />
                                <InputError message={errors.adresse} className="mt-1 text-red-500 text-xs" />
                            </div>
                        </div>

                        <div className="grid grid-cols-2 gap-4">
                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Mot de passe</label>
                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    value={data.password}
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('password', e.target.value)}
                                    required
                                />
                                <InputError message={errors.password} className="mt-1 text-red-500 text-xs" />
                            </div>

                            <div>
                                <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Confirmer</label>
                                <input
                                    id="password_confirmation"
                                    type="password"
                                    name="password_confirmation"
                                    value={data.password_confirmation}
                                    className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                    onChange={(e) => setData('password_confirmation', e.target.value)}
                                    required
                                />
                                <InputError message={errors.password_confirmation} className="mt-1 text-red-500 text-xs" />
                            </div>
                        </div>

                        <div className="pt-2">
                            <button
                                type="button"
                                onClick={nextStep}
                                className="w-full px-6 py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all flex items-center justify-center gap-2"
                            >
                                Suivant
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        </div>
                    </div>
                )}

                {step === 2 && (
                    <div className="space-y-4 animate-fadeIn">
                        <div>
                            <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Nom de la communauté / Daara</label>
                            <input
                                id="communaute_nom"
                                name="communaute_nom"
                                value={data.communaute_nom}
                                placeholder="Ex: Daara Mouhadimatul Xidma"
                                className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all"
                                onChange={(e) => setData('communaute_nom', e.target.value)}
                                required
                                autoFocus
                            />
                            <InputError message={errors.communaute_nom} className="mt-1 text-red-500 text-xs" />
                        </div>

                        <div>
                            <label className="block text-[10px] font-black text-cedar-950 uppercase tracking-widest mb-1.5">Description de la communauté</label>
                            <textarea
                                id="communaute_description"
                                name="communaute_description"
                                value={data.communaute_description}
                                placeholder="Décrivez brièvement la vocation ou l'emplacement de votre communauté..."
                                rows={5}
                                className="w-full bg-cedar-50 border border-cedar-200 rounded-xl px-4 py-2.5 text-sm font-bold text-cedar-900 outline-none focus:ring-2 focus:ring-cedar-300 transition-all resize-none"
                                onChange={(e) => setData('communaute_description', e.target.value)}
                                required
                            />
                            <InputError message={errors.communaute_description} className="mt-1 text-red-500 text-xs" />
                        </div>

                        <div className="grid grid-cols-3 gap-3 pt-2">
                            <button
                                type="button"
                                onClick={prevStep}
                                className="col-span-1 px-4 py-3.5 border border-cedar-200 hover:bg-cedar-50 text-cedar-800 rounded-xl text-sm font-black transition-all flex items-center justify-center gap-1"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" className="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="3" d="M15 19l-7-7 7-7" />
                                </svg>
                                Retour
                            </button>

                            <button
                                type="submit"
                                disabled={processing}
                                className="col-span-2 px-6 py-3.5 bg-cedar-900 hover:bg-cedar-950 text-white rounded-xl text-sm font-black shadow-xl shadow-cedar-950/10 transition-all"
                            >
                                S'inscrire & Créer
                            </button>
                        </div>
                    </div>
                )}

                <div className="text-center mt-4 pt-2 border-t border-cedar-100">
                    <p className="text-xs font-bold text-cedar-600">
                        Déjà inscrit ?{' '}
                        <Link
                            href={route('login')}
                            className="text-cedar-900 hover:text-cedar-950 underline decoration-2 underline-offset-4"
                        >
                            Se connecter
                        </Link>
                    </p>
                </div>
            </form>
        </GuestLayout>
    );
}
