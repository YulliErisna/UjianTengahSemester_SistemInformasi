// src/pages/Login.tsx (e-Laboratorium Green Theme)

import React, { useState, useEffect } from "react";
import { useNavigate, Link } from "react-router-dom";
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
import {
  LogIn,
  Lock,
  AtSign,
  Eye,
  EyeOff,
  UserCircle,
  Users,
  Beaker,
} from "lucide-react";
import { toast } from "sonner";
import { useAuth } from "@/contexts/AuthContext";
import { motion } from "framer-motion";
import { RadioGroup, RadioGroupItem } from "@/components/ui/radio-group";

const containerVariants = {
  hidden: { opacity: 0 },
  visible: {
    opacity: 1,
    transition: { duration: 0.5, when: "beforeChildren", staggerChildren: 0.1 },
  },
};

const itemVariants = {
  hidden: { y: 20, opacity: 0 },
  visible: {
    y: 0,
    opacity: 1,
    transition: { type: "spring", stiffness: 300, damping: 24 },
  },
};

const Login = () => {
  const [npm, setNpm] = useState("");
  const [password, setPassword] = useState("");
  const [role, setRole] = useState<"mahasiswa" | "aslab">("mahasiswa");
  const [isLoading, setIsLoading] = useState(false);
  const [showPassword, setShowPassword] = useState(false);
  const navigate = useNavigate();
  const { login } = useAuth();

  useEffect(() => {
    const isDark = document.documentElement.classList.contains("dark");
  }, []);

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setIsLoading(true);

    const apiUrl =
      import.meta.env.VITE_API_URL + "/api/login" ||
      "http://127.0.0.1:8000/api/login";

    try {
      const response = await fetch(apiUrl, {
        method: "POST",
        headers: {
          "Content-Type": "application/json",
          Accept: "application/json",
        },
        body: JSON.stringify({ npm, password }),
      });

      const data = await response.json();

      if (response.ok) {
        if (!data.user) {
          toast.error("Gagal memproses data login dari server.");
          setIsLoading(false);
          return;
        }

        const backendRoleLower = data.user.role.toLowerCase();
        if (backendRoleLower !== role && backendRoleLower !== "admin") {
          toast.error(`Role tidak cocok: ${data.user.role}`);
          setIsLoading(false);
          return;
        }

        toast.success(`Login berhasil sebagai ${data.user.role}!`);

        if (data.user && data.token) {
          login(data.user, data.token);
        }

        navigate("/");
      } else {
        toast.error(data.message || "NPM atau password salah.");
      }
    } catch (error) {
      toast.error("Koneksi gagal. Periksa server backend.");
    } finally {
      setIsLoading(false);
    }
  };

  const togglePasswordVisibility = () => {
    setShowPassword(!showPassword);
  };

  return (
    <div className="min-h-screen flex items-center justify-center bg-gradient-to-br from-white to-emerald-50 dark:from-slate-900 dark:to-slate-800 p-4">
      <motion.div
        className="w-full max-w-md"
        variants={containerVariants}
        initial="hidden"
        animate="visible"
      >
        {/* Logo & Title */}
        <motion.div className="text-center mb-8" variants={itemVariants}>
          <motion.div
            className="inline-block p-4 bg-gradient-to-br from-emerald-500 to-emerald-600 rounded-2xl mb-4 shadow-lg hover:shadow-emerald-400/50 transition-shadow card-hover"
            whileHover={{ scale: 1.05 }}
            whileTap={{ scale: 0.98 }}
          >
            <Beaker className="h-12 w-12 text-white" />
          </motion.div>
          <h1 className="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-emerald-500 bg-clip-text text-transparent mb-2">
            e-Laboratorium
          </h1>
          <p className="text-muted-foreground">Laboratory Information System</p>
        </motion.div>

        {/* Form Card */}
        <motion.div variants={itemVariants}>
          <Card className="border-0 shadow-xl overflow-hidden card-hover">
            <div className="absolute top-0 left-0 right-0 h-1 bg-gradient-to-r from-emerald-500 to-emerald-600"></div>
            <CardHeader className="space-y-1">
              <CardTitle className="text-2xl font-bold text-center text-foreground">
                Masuk
              </CardTitle>
              <CardDescription className="text-center">
                Masukkan NPM dan kata sandi untuk mengakses sistem
              </CardDescription>
            </CardHeader>
            <CardContent className="space-y-4">
              <form onSubmit={handleLogin}>
                <div className="space-y-4">
                  <div className="space-y-2">
                    <Label htmlFor="npm">NPM</Label>
                    <div className="relative">
                      <AtSign className="absolute left-3 top-3 h-5 w-5 text-muted-foreground" />
                      <Input
                        id="npm"
                        placeholder="Masukkan NPM Anda"
                        value={npm}
                        onChange={(e) => setNpm(e.target.value)}
                        required
                        className="h-12 pl-11 pr-11 focus-visible:ring-emerald-500 focus-visible:border-emerald-500 transition-all rounded-xl"
                      />
                    </div>
                  </div>
                  <div className="space-y-2">
                    <Label htmlFor="password">Kata Sandi</Label>
                    <div className="relative">
                      <Lock className="absolute left-3 top-3 h-5 w-5 text-muted-foreground" />
                      <Input
                        id="password"
                        type={showPassword ? "text" : "password"}
                        placeholder="Masukkan kata sandi"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                        required
                        className="h-12 pl-11 pr-11 focus-visible:ring-emerald-500 focus-visible:border-emerald-500 transition-all rounded-xl"
                      />
                      <button
                        type="button"
                        onClick={togglePasswordVisibility}
                        className="absolute right-3 top-3 text-muted-foreground hover:text-foreground transition-colors"
                      >
                        {showPassword ? (
                          <EyeOff className="h-5 w-5" />
                        ) : (
                          <Eye className="h-5 w-5" />
                        )}
                      </button>
                    </div>
                  </div>

                  <div className="space-y-2">
                    <Label>Pilih Role</Label>
                    <RadioGroup
                      value={role}
                      onValueChange={(value) =>
                        setRole(value as "mahasiswa" | "aslab")
                      }
                      className="flex flex-col space-y-2 p-3 bg-muted/20 rounded-xl border"
                    >
                      <div className="flex items-center space-x-3 p-3 rounded-lg cursor-pointer hover:bg-muted transition-colors">
                        <RadioGroupItem value="mahasiswa" id="mahasiswa" />
                        <Label
                          htmlFor="mahasiswa"
                          className="flex items-center cursor-pointer font-medium"
                        >
                          <UserCircle className="h-5 w-5 mr-2 text-emerald-500" />
                          Mahasiswa
                        </Label>
                      </div>
                      <div className="flex items-center space-x-3 p-3 rounded-lg cursor-pointer hover:bg-muted transition-colors">
                        <RadioGroupItem value="aslab" id="aslab" />
                        <Label
                          htmlFor="aslab"
                          className="flex items-center cursor-pointer font-medium"
                        >
                          <Users className="h-5 w-5 mr-2 text-emerald-400" />
                          Aslab
                        </Label>
                      </div>
                    </RadioGroup>
                  </div>
                </div>

                <motion.div
                  whileHover={{ scale: 1.02 }}
                  whileTap={{ scale: 0.98 }}
                  className="mt-6"
                >
                  <Button
                    type="submit"
                    className="w-full h-12 text-base font-medium bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 shadow-lg hover:shadow-emerald-300/50 transition-all rounded-xl"
                    disabled={isLoading}
                  >
                    {isLoading ? (
                      <div className="flex items-center justify-center">
                        <svg
                          className="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                          xmlns="http://www.w3.org/2000/svg"
                          fill="none"
                          viewBox="0 0 24 24"
                        >
                          <circle
                            className="opacity-25"
                            cx="12"
                            cy="12"
                            r="10"
                            stroke="currentColor"
                            strokeWidth="4"
                          ></circle>
                          <path
                            className="opacity-75"
                            fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                          ></path>
                        </svg>
                        Masuk...
                      </div>
                    ) : (
                      <span className="flex items-center justify-center">
                        <LogIn className="mr-2 h-5 w-5" /> Masuk ke
                        e-Laboratorium
                      </span>
                    )}
                  </Button>
                </motion.div>
              </form>
            </CardContent>
            <CardFooter className="flex flex-col border-t pt-4 bg-muted/30">
              <p className="text-sm text-center text-muted-foreground">
                Belum punya akun?{" "}
                <Link
                  to="/signup"
                  className="font-medium text-primary hover:text-primary/80 transition-colors"
                >
                  Daftar sekarang
                </Link>
              </p>
            </CardFooter>
          </Card>
        </motion.div>
      </motion.div>

      {/* Modern Blobs */}
      <div className="fixed top-20 right-20 w-72 h-72 bg-emerald-400/10 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob"></div>
      <div className="fixed bottom-20 left-20 w-72 h-72 bg-emerald-300/10 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-2000"></div>
      <div className="fixed bottom-40 right-40 w-72 h-72 bg-emerald-200/10 rounded-full mix-blend-multiply filter blur-xl opacity-30 animate-blob animation-delay-4000"></div>
    </div>
  );
};

export default Login;
