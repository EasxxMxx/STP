import { useState, useEffect } from 'react';
import { Head } from '@inertiajs/react';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';
import CourseFilters from '@/Components/CourseFilters';
import PrimaryButton from '@/Components/PrimaryButton';

export default function CourseDetail({ auth }) {
    const [courses, setCourses] = useState([]);
    const [loading, setLoading] = useState(true);
    const [currentPage, setCurrentPage] = useState(1);
    const [lastPage, setLastPage] = useState(1);
    const [filters, setFilters] = useState({
        search: '',
        category: null,
        qualification: null,
        studyMode: null
    });

    const fetchCourses = async (page = 1) => {
        try {
            setLoading(true);
            
            const params = new URLSearchParams({
                page: page,
                per_page: 20,
            });

            if (filters.search) params.append('search', filters.search);
            if (filters.category && filters.category.length > 0) {
                filters.category.forEach(catId => params.append('category[]', catId));
            }
            if (filters.qualification) params.append('qualification', filters.qualification);
            if (filters.studyMode && filters.studyMode.length > 0) {
                filters.studyMode.forEach(modeId => params.append('studyMode[]', modeId));
            }

            const response = await fetch(`/api/student/courseList?${params}`);
            const data = await response.json();

            if (data.data || Array.isArray(data)) {
                const courseData = data.data || data;
                setCourses(courseData);
                if (data.current_page) setCurrentPage(data.current_page);
                if (data.last_page) setLastPage(data.last_page);
            }
        } catch (error) {
            console.error('Error fetching courses:', error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchCourses(1);
    }, [filters]);

    const handleFilterChange = (newFilters) => {
        setFilters(prevFilters => ({
            ...prevFilters,
            ...newFilters
        }));
    };

    const handlePageChange = (page) => {
        if (page >= 1 && page <= lastPage) {
            fetchCourses(page);
        }
    };

    const formatCurrency = (amount) => {
        if (!amount) return 'Contact for pricing';
        return new Intl.NumberFormat('en-MY', {
            style: 'currency',
            currency: 'MYR'
        }).format(amount);
    };

    return (
        <AuthenticatedLayout user={auth.user}>
            <Head title="Course Details" />
            
            <div className="py-12">
                <div className="max-w-7xl mx-auto sm:px-6 lg:px-8">
                    <div className="mb-6">
                        <h1 className="text-2xl font-semibold text-gray-900">Course Details</h1>
                        <p className="mt-1 text-sm text-gray-600">Find and explore courses that match your interests</p>
                    </div>

                    <CourseFilters 
                        onFilterChange={handleFilterChange} 
                        filters={filters} 
                    />

                    <div className="bg-white shadow-sm rounded-lg">
                        {loading ? (
                            <div className="flex justify-center items-center py-12">
                                <div className="animate-spin rounded-full h-8 w-8 border-b-2 border-indigo-500"></div>
                            </div>
                        ) : courses.length > 0 ? (
                            <>
                                <div className="divide-y divide-gray-200">
                                    {courses.map((course) => (
                                        <div key={course.id} className="p-6 hover:bg-gray-50">
                                            <div className="flex items-start space-x-4">
                                                {course.logo && (
                                                    <img 
                                                        src={course.logo} 
                                                        alt={course.name || course.course_name}
                                                        className="w-16 h-16 rounded-lg object-cover flex-shrink-0"
                                                    />
                                                )}
                                                
                                                <div className="flex-1 min-w-0">
                                                    <h3 className="text-lg font-medium text-gray-900 mb-1">
                                                        {course.name || course.course_name}
                                                    </h3>
                                                    
                                                    <p className="text-sm text-gray-600 mb-2">
                                                        {course.school_name}
                                                    </p>
                                                    
                                                    <div className="flex flex-wrap gap-4 text-sm text-gray-500 mb-3">
                                                        {course.category && (
                                                            <span className="inline-flex items-center">
                                                                <svg className="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                                                </svg>
                                                                {course.category}
                                                            </span>
                                                        )}
                                                        
                                                        {course.qualification && (
                                                            <span className="inline-flex items-center">
                                                                <svg className="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                                                </svg>
                                                                {course.qualification}
                                                            </span>
                                                        )}
                                                        
                                                        {course.mode && (
                                                            <span className="inline-flex items-center">
                                                                <svg className="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                </svg>
                                                                {course.mode}
                                                            </span>
                                                        )}
                                                        
                                                        {course.period && (
                                                            <span className="inline-flex items-center">
                                                                <svg className="w-4 h-4 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                                </svg>
                                                                {course.period}
                                                            </span>
                                                        )}
                                                    </div>
                                                    
                                                    {course.description && (
                                                        <p className="text-sm text-gray-600 mb-3 line-clamp-2">
                                                            {course.description}
                                                        </p>
                                                    )}
                                                    
                                                    <div className="flex items-center space-x-4 text-sm">
                                                        <span className="font-medium text-green-600">
                                                            {formatCurrency(course.cost)}
                                                        </span>
                                                        {course.international_cost && course.international_cost !== course.cost && (
                                                            <span className="text-gray-500">
                                                                International: {formatCurrency(course.international_cost)}
                                                            </span>
                                                        )}
                                                    </div>
                                                </div>
                                                
                                                <div className="flex-shrink-0">
                                                    <PrimaryButton>
                                                        View Details
                                                    </PrimaryButton>
                                                </div>
                                            </div>
                                        </div>
                                    ))}
                                </div>
                                
                                {lastPage > 1 && (
                                    <div className="px-6 py-4 border-t border-gray-200">
                                        <div className="flex items-center justify-between">
                                            <div className="text-sm text-gray-700">
                                                Page {currentPage} of {lastPage}
                                            </div>
                                            
                                            <div className="flex space-x-2">
                                                <button
                                                    onClick={() => handlePageChange(currentPage - 1)}
                                                    disabled={currentPage === 1}
                                                    className="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    Previous
                                                </button>
                                                
                                                <button
                                                    onClick={() => handlePageChange(currentPage + 1)}
                                                    disabled={currentPage === lastPage}
                                                    className="px-3 py-1 text-sm border border-gray-300 rounded-md hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed"
                                                >
                                                    Next
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                )}
                            </>
                        ) : (
                            <div className="text-center py-12">
                                <svg className="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path strokeLinecap="round" strokeLinejoin="round" strokeWidth={2} d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <h3 className="mt-2 text-sm font-medium text-gray-900">No courses found</h3>
                                <p className="mt-1 text-sm text-gray-500">
                                    Try adjusting your search criteria or filters
                                </p>
                            </div>
                        )}
                    </div>
                </div>
            </div>
        </AuthenticatedLayout>
    );
}