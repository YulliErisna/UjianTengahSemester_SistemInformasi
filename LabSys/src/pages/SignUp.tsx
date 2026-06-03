import React, { useState } from "react";
import { Link, useNavigate } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle,
} from "@/components/ui/card";
import { Label } from "@/components/ui/label";
import { Eye, EyeOff, Mail, User, Hash, Lock } from "lucide-react";
import { toast } from "sonner";
import { motion } from "framer-motion";

const containerVariants = {
  hidden: { opacity: 0, y: 30 },
  visible: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.6, ease: "easeOut" },
  },
};

const itemVariants = {
  hidden: { opacity: 0, y: 20 },
  visible: {
    opacity: 1,
    y: 0,
    transition: { duration: 0.4 },
  },
};

const SignUp = () => {
  const [formData, setFormData] = useState({
    npm: "",
    name: "",
    email: "",
    password: "",
    password_confirmation: "",
  });
  const [showPassword, setShowPassword] = useState(false);
  const [showPasswordConfirmation, setShowPasswordConfirmation] =
    useState(false);
  const [isLoading, setIsLoading] = useState(false);
  const navigate = useNavigate();

  const handleInputChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    setFormData({
      ...formData,
      [e.target.name]: e.target.value,
    });
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);

    if (formData.password !== formData.password_confirmation) {
      toast.error("Konfirmasi password tidak cocok");
      setIsLoading(false);
      return;
    }

    try {
      const response = await fetch("http://127.0.0.1:8000/api/register", {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify(formData),
      });

      const data = await response.json();

      if (response.ok) {
        toast.success(data.message || "Registrasi berhasil!");
        navigate("/login");
      } else {
        const errorMsg =
          data.message ||
          Object.values(data.errors || {})
            .flat()
            .join(", ");
        toast.error(errorMsg);
      }
    } catch (error) {
      toast.error("Koneksi gagal. Pastikan server backend berjalan.");
    } finally {
      setIsLoading(false);
    }
  };

  return (
    <div className="min-h-screen bg-gradient-to-br from-white via-emerald-50 to-teal-50 flex items-center justify-center p-4">
      <motion.div
        className="w-full max-w-md"
        variants={containerVariants}
        initial="hidden"
        animate="visible"
      >
        {/* Decorative Elements */}
        <div className="absolute top-20 -right-20 w-72 h-72 bg-emerald-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
        <div className="absolute bottom-20 -left-20 w-72 h-72 bg-teal-200 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
        <div className="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-emerald-100 rounded-full mix-blend-multiply filter blur-2xl opacity-20 animate-pulse"></div>

        <Card className="backdrop-blur-sm bg-white/90 border-emerald-100 shadow-2xl border ring-emerald-200/50 ring-opacity-5 overflow-hidden">
          <CardHeader className="bg-gradient-to-r from-emerald-500 to-teal-500 text-white text-center">
            <motion.div
              className="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4 backdrop-blur-sm"
              variants={itemVariants}
              whileHover={{ scale: 1.05 }}
            >
              <Hash className="h-8 w-8" />
            </motion.div>
            <CardTitle className="text-2xl font-bold">
              Daftar Akun Baru
            </CardTitle>
            <CardDescription className="text-emerald-100">
              Buat akun untuk mengakses sistem e-Laboratorium
            </CardDescription>
          </CardHeader>

          <CardContent className="p-8 space-y-6">
            <form onSubmit={handleSubmit} className="space-y-5">
              {/* NPM */}
              <motion.div variants={itemVariants} className="space-y-2">
                <Label
                  htmlFor="npm"
                  className="text-sm font-medium text-foreground"
                >
                  NPM
                </Label>
                <div className="relative">
                  <Hash className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-emerald-500" />
                  <Input
                    id="npm"
                    name="npm"
                    type="text"
                    placeholder="Masukkan NPM Anda"
                    value={formData.npm}
                    onChange={handleInputChange}
                    required
                    className="h-12 pl-10 pr-4 border-emerald-200 focus-visible:ring-emerald-500 focus-visible:ring-2 rounded-xl transition-all duration-200"
                  />
                </div>
              </motion.div>

              {/* Nama */}
              <motion.div variants={itemVariants} className="space-y-2">
                <Label
                  htmlFor="name"
                  className="text-sm font-medium text-foreground"
                >
                  Nama Lengkap
                </Label>
                <div className="relative">
                  <User className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-emerald-500" />
                  <Input
                    id="name"
                    name="name"
                    type="text"
                    placeholder="Masukkan nama lengkap"
                    value={formData.name}
                    onChange={handleInputChange}
                    required
                    className="h-12 pl-10 pr-4 border-emerald-200 focus-visible:ring-emerald-500 focus-visible:ring-2 rounded-xl transition-all duration-200"
                  />
                </div>
              </motion.div>

              {/* Email */}
              <motion.div variants={itemVariants} className="space-y-2">
                <Label
                  htmlFor="email"
                  className="text-sm font-medium text-foreground"
                >
                  Email
                </Label>
                <div className="relative">
                  <Mail className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-emerald-500" />
                  <Input
                    id="email"
                    name="email"
                    type="email"
                    placeholder="example@studen.ac.id"
                    value={formData.email}
                    onChange={handleInputChange}
                    required
                    className="h-12 pl-10 pr-4 border-emerald-200 focus-visible:ring-emerald-500 focus-visible:ring-2 rounded-xl transition-all duration-200"
                  />
                </div>
              </motion.div>

              {/* Password */}
              <motion.div variants={itemVariants} className="space-y-2">
                <Label
                  htmlFor="password"
                  className="text-sm font-medium text-foreground"
                >
                  Kata Sandi
                </Label>
                <div className="relative">
                  <Lock className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-emerald-500" />
                  <Input
                    id="password"
                    name="password"
                    type={showPassword ? "text" : "password"}
                    placeholder="Buat kata sandi aman"
                    value={formData.password}
                    onChange={handleInputChange}
                    required
                    minLength={8}
                    className="h-12 pl-10 pr-12 border-emerald-200 focus-visible:ring-emerald-500 focus-visible:ring-2 rounded-xl transition-all duration-200"
                  />
                  <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    className="absolute right-3 top-1/2 -translate-y-1/2 h-6 w-6 p-0 hover:bg-transparent"
                    onClick={() => setShowPassword(!showPassword)}
                  >
                    {showPassword ? (
                      <EyeOff className="h-4 w-4" />
                    ) : (
                      <Eye className="h-4 w-4" />
                    )}
                  </Button>
                </div>
              </motion.div>

              {/* Confirm Password */}
              <motion.div variants={itemVariants} className="space-y-2">
                <Label
                  htmlFor="password_confirmation"
                  className="text-sm font-medium text-foreground"
                >
                  Konfirmasi Kata Sandi
                </Label>
                <div className="relative">
                  <Lock className="absolute left-3 top-1/2 -translate-y-1/2 h-4 w-4 text-emerald-500" />
                  <Input
                    id="password_confirmation"
                    name="password_confirmation"
                    type={showPasswordConfirmation ? "text" : "password"}
                    placeholder="Ulangi kata sandi"
                    value={formData.password_confirmation}
                    onChange={handleInputChange}
                    required
                    className="h-12 pl-10 pr-12 border-emerald-200 focus-visible:ring-emerald-500 focus-visible:ring-2 rounded-xl transition-all duration-200"
                  />
                  <Button
                    type="button"
                    variant="ghost"
                    size="sm"
                    className="absolute right-3 top-1/2 -translate-y-1/2 h-6 w-6 p-0 hover:bg-transparent"
                    onClick={() =>
                      setShowPasswordConfirmation(!showPasswordConfirmation)
                    }
                  >
                    {showPasswordConfirmation ? (
                      <EyeOff className="h-4 w-4" />
                    ) : (
                      <Eye className="h-4 w-4" />
                    )}
                  </Button>
                </div>
              </motion.div>

              <motion.div variants={itemVariants}>
                <Button
                  type="submit"
                  className="w-full h-12 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-semibold rounded-xl shadow-lg hover:shadow-emerald-500/25 transition-all duration-300 text-base"
                  disabled={isLoading}
                >
                  {isLoading ? (
                    <>
                      <svg
                        className="animate-spin -ml-1 mr-2 h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                      >
                        <circle
                          cx="12"
                          cy="12"
                          r="10"
                          stroke="currentColor"
                          strokeWidth="4"
                          className="opacity-25"
                        />
                        <path
                          fill="currentColor"
                          d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                          className="opacity-75"
                        />
                      </svg>
                      Membuat Akun...
                    </>
                  ) : (
                    "Daftar Sekarang"
                  )}
                </Button>
              </motion.div>
            </form>
          </CardContent>

          <CardFooter className="justify-center px-8 pb-8 pt-0 border-t border-emerald-100 bg-gradient-to-t from-emerald-50/50 to-transparent">
            <p className="text-sm text-muted-foreground">
              Sudah punya akun?{" "}
              <Link
                to="/login"
                className="font-semibold text-emerald-600 hover:text-emerald-700 transition-colors duration-200 underline-offset-2 hover:underline"
              >
                Masuk sekarang
              </Link>
            </p>
          </CardFooter>
        </Card>
      </motion.div>
    </div>
  );
};

export default SignUp;
