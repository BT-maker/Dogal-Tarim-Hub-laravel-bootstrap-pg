class AuthService{
    constructor(){
        this.baseURL = '/api/auth';
        this.token = localStorage.getItem('auth_token');
    }


    //SHA-256 ile şifre hashleme (crypto-js olmadan)
    async hashPassword(password){
        const encoder = new TextEncoder();
        const data = encoder.encode(password);
        const hashBuffer = await crypto.subtle.digest('SHA-256',data);
        const hashArray = Array.from(new Uint8Array(hashBuffer));
        return hashArray.map(b => b.toString(16).padStart(2,'0')).join('');
    }


    //API çağrısı için header
    getHeaders() {
        const headers = {
            'Content-Type':'application/json',
            'Accept':'application/json'
        };

        if (this.token){
            headers['Authorization']= `Bearer $[this.token]`;
        }

        return headers;
    }


    //Kayıt ol
    async register(name, email, password){
        const hashedPassword = await this.hashPassword(password);

        try{
            const response = await fetch(`${this.baseURL}/register`,{
                method:'POST',
                headers: this.getHeaders(),
                body: JSON.stringify({
                    name,
                    email,
                    password:hashedPassword
                })
            });

            const data = await response.json();

            if(data.success){
                this.token = data.token;
                localStorage.setItem('auth_token', this.token);
                localStorage.setItem('user', JSON.stringify(data.user));
            }

            return data;
        }catch(error){
            return {success:false, message:'Network error'};
        }
    }

    //Giriş yap
    async login(email, password){

        const hashedPassword = await this.hashPassword(password);

        try{
            const response = await fetch(`${this.baseURL}/login`,{
                methos: 'POST',
                headers: this.getHeaders(),
                body: JSON.stringify({
                    email,
                    password: hashedPassword
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
            return{success: false, message: 'Network error'};
        }
        
    }



    //Çıkış yap
    async logout(){
        try{
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

    //Kullanıcı giriş yapmış mı?
    isAuthenticated(){
        return !!this.token;
    }

    //Kullanıcı bilgilerini al
    getuser(){
        const user = localStorage.getItem('user');
        return user ? JSON.parse(user) : null;
    }
}

//Global olarak kullanılabilir hale getir

window.AuthService = new AuthService();