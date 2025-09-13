import CryptoJS  from "crypto-js";

class AuthService{
    constructor(){
        this.baseURL ='/api/auth';
        this.token = localStorage.getItem('auth_token');
    }


    //SHA-256 ile şifre hashleme
    hashPassword(password){
        return CryptoJS.SHA256(password).toString();
    }

    //API çağrısı için header
    getHeaders() {
        const headers = {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        };
        
        if (this.token) {
            headers['Authorization'] = `Bearer ${this.token}`;
        }
        
        return headers;
    }

    //Kayıt ol
    async register(name, email, password){
        try{
            const response = await fetch(`${this.baseURL}/register`,{
                method:'POST',
                headers:this.getHeaders(),
                body:JSON.stringify({
                    name,
                    email,
                    password:this.hashPassword
                })
            });
            const data = await response.json();

            if(data.success){
                this.token = data.token;
                localStorage.setItem('auth_token', this.token);
                localStorage.setItem('user', JSON.stringify(data.user));
            }

            return data;
        }catch (error){
            return{ success: false, message:'Network error'};
        }
    }

    //Giriş yap
    async login(email, password){
        const hashPassword = this.hashPassword(password);

        try{
            const response = await fetch(`${this.baseURL}/login`,{
                method: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify({
                    email,
                    password:hashedPasword
                })
            });

            const data = await response.json();

            if(data.success){
                this.token = data.token;
                localStorage.setItem('auth_token',this.token);
                localStorage.setItem('user',JSON.stringify(data.user));
            }

            return data;
        }catch (error){
            return { success: false, message: 'Network error'};
        }
    }

    //çıkış yap
    async logout(){
        try {
            await fetch(`${this.baseURL}/logout`,{
                method: 'POST',
                headers: this.getHeaders()
            });
        }catch (error){
            console.log('Logout error:', error);
        }

        this.token = null;
        localStorage.removeItem('auth_token');
        localStorage.removeItem('user');
    }


    //Kullanıcı giriş yapmışmı
    isAuthenticated(){
        return !!this.token;
    }

    //kullanıcı bilgileri al
    getUser(){
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }
}

export default new AuthService();